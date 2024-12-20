<?php

namespace App\Weather;

interface WeatherFactoryInterface
{
    public function createWeatherService(): WeatherServiceInterface;
}
