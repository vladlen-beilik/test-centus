<?php

namespace App\Weather;

use App\Models\City;

interface WeatherServiceInterface
{
    public function getWeather(City $city): array;
}
