<?php

namespace App\Weather\Factories;

use App\Weather\Services\OpenWeatherService;
use App\Weather\WeatherFactoryInterface;
use App\Weather\WeatherServiceInterface;

class OpenWeatherFactory implements WeatherFactoryInterface
{
    public function createWeatherService(): WeatherServiceInterface
    {
        return new OpenWeatherService();
    }
}
