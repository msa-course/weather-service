<?php

use App\Domain\Weather\Actions\GetActualWeather;
use Mockery\MockInterface;
use Tests\TestCase;

use function Pest\Laravel\getJson;

it('returns weather data', function () {
    /** @var TestCase $this */

    $expected = [
        'temp' => 9,
        'feels_like' => 2,
        'condition' => 'overcast',
        'humidity' => 55,
        'wind_speed' => 7,
        'wind_gust' => 12.2,
        'wind_dir' => 's',
        'pressure_mm' => 758,
        'observed_at' => 1773597600,
        'timezone' => 'Europe/Moscow',
        'lat' => 55.9825,
        'lon' => 37.1814,
    ];

    $this->mock(GetActualWeather::class, function (MockInterface $mock) use ($expected) {
        $mock->shouldReceive('execute')
            ->once()
            ->with(55.9825, 37.1814)
            ->andReturn($expected);
    });

    getJson('/api/weather?lat=55.9825&lon=37.1814')
        ->assertOk()
        ->assertExactJson($expected);
});

it('validates required query params', function () {
    getJson('/api/weather')
        ->assertStatus(422)
        ->assertJsonValidationErrors(['lat', 'lon']);
});

it('validates lat and lon ranges', function () {
    getJson('/api/weather?lat=999&lon=999')
        ->assertStatus(422)
        ->assertJsonValidationErrors(['lat', 'lon']);
});
