<?php

use App\Domain\Weather\Actions\GetActualWeather;
use App\Integrations\YandexWeather\YandexWeatherClient;
use Mockery\MockInterface;
use Tests\TestCase;

it('fetches actual weather and returns normalized payload', function () {
    /** @var TestCase $this */

    $payload = [
        'fact' => [
            'temp' => 9,
            'feels_like' => 2,
            'condition' => 'overcast',
            'humidity' => 55,
            'wind_speed' => 7,
            'wind_gust' => 12.2,
            'wind_dir' => 's',
            'pressure_mm' => 758,
            'obs_time' => 1773597600,
        ],
        'info' => [
            'lat' => 55.9825,
            'lon' => 37.1814,
            'tzinfo' => [
                'name' => 'Europe/Moscow',
            ],
        ],
    ];

    $this->mock(YandexWeatherClient::class, function (MockInterface $mock) use ($payload) {
        $mock->shouldReceive('forecast')
            ->once()
            ->with(55.9825, 37.1814)
            ->andReturn($payload);
    });

    $result = app(GetActualWeather::class)->execute(55.9825, 37.1814);

    expect($result)->toBe([
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
    ]);
});
