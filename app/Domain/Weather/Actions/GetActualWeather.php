<?php

namespace App\Domain\Weather\Actions;

use App\Integrations\YandexWeather\YandexWeatherClient;
use Illuminate\Support\Arr;

class GetActualWeather
{
    public function __construct(
        private readonly YandexWeatherClient $client,
    ) {}

    public function execute(float $lat, float $lon): array
    {
        $payload = $this->client->forecast($lat, $lon);

        return [
            'temp' => Arr::get($payload, 'fact.temp'),
            'feels_like' => Arr::get($payload, 'fact.feels_like'),
            'condition' => Arr::get($payload, 'fact.condition'),
            'humidity' => Arr::get($payload, 'fact.humidity'),
            'wind_speed' => Arr::get($payload, 'fact.wind_speed'),
            'wind_gust' => Arr::get($payload, 'fact.wind_gust'),
            'wind_dir' => Arr::get($payload, 'fact.wind_dir'),
            'pressure_mm' => Arr::get($payload, 'fact.pressure_mm'),
            'observed_at' => Arr::get($payload, 'fact.obs_time'),
            'timezone' => Arr::get($payload, 'info.tzinfo.name'),
            'lat' => Arr::get($payload, 'info.lat'),
            'lon' => Arr::get($payload, 'info.lon'),
        ];
    }
}
