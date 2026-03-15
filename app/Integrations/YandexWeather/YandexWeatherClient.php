<?php

namespace App\Integrations\YandexWeather;

use Illuminate\Support\Facades\Http;

class YandexWeatherClient
{
    public function forecast(float $lat, float $lon): array
    {
        return Http::baseUrl(config('services.yandex_weather.base_url'))
            ->withHeaders([
                'X-Yandex-Weather-Key' => config('services.yandex_weather.access_key'),
            ])
            ->acceptJson()
            ->timeout(10)
            ->retry(3, 200)
            ->get('/v2/forecast', [
                'lat' => $lat,
                'lon' => $lon,
            ])
            ->throw()
            ->json();
    }
}
