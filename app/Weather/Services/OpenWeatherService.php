<?php

namespace App\Weather\Services;

use App\Models\City;
use App\Weather\WeatherServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class OpenWeatherService implements WeatherServiceInterface
{
    private string $host;
    private ?string $key;
    private string $version;

    public function __construct()
    {
        $this->host = 'api.openweathermap.org';
        $this->version = config('services.open_weather.api_version');
        $this->key = config('services.open_weather.api_key');
    }

    public function getWeather(City $city): array
    {
        try {
            $response = Http::get("https://$this->host/data/$this->version/onecall", [
                'lat' => $city->lat,
                'lon' => $city->lng,
                'appid' => $this->key
            ]);

            if($response->successful()) {
                $precipitation = null;
                $uvi = null;
            } else {
                Log::error($response->json());
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return [
            'service' => 'openweather',
            'precipitation' => $precipitation ?? null,
            'uvi' => $uvi ?? null,
        ];
    }
}
