<?php

use App\Http\Controllers\Api\WeatherController;
use Illuminate\Support\Facades\Route;

// api/weather?lat=55.9825&lon=37.1814
Route::get('/weather', [WeatherController::class, 'show']);
