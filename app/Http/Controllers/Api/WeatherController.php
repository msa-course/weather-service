<?php

namespace App\Http\Controllers\Api;

use App\Domain\Weather\Actions\GetActualWeather;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeatherController extends Controller
{
    public function show(Request $request, GetActualWeather $action): JsonResponse
    {
        $validated = $request->validate([
            'lat' => ['required', 'numeric', 'between:-90,90'],
            'lon' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $data = $action->execute(
            lat: (float) $validated['lat'],
            lon: (float) $validated['lon'],
        );

        return response()->json($data);
    }
}
