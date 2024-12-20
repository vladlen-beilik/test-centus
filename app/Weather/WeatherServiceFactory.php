<?php

namespace App\Weather;

use InvalidArgumentException;

class WeatherServiceFactory
{
    public static function createService(string $serviceType): WeatherServiceInterface
    {
        return match ($serviceType) {
            'openweather' => new Services\OpenWeatherService(),
            'weatherstack' => new Services\WeatherStackService(),
            'accuweather' => new Services\AccuWeatherService(),
            default => throw new InvalidArgumentException("Unknown service type: $serviceType"),
        };
    }
}
