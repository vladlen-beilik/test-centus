<?php

namespace App\Weather\Services;

use App\Models\City;
use App\Weather\WeatherServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class WeatherStackService implements WeatherServiceInterface
{
    private string $host;
    private ?string $key;

    public function __construct()
    {
        $this->host = 'api.weatherstack.com';
        $this->key = config('services.weather_stack.api_key');
    }

    public function getWeather(City $city): array
    {
        try {
            $response = Http::get("http://$this->host/current", [
                'access_key' => $this->key,
                'query' => "$city->lat,$city->lng"
            ]);

            if($response->successful()) {
                $data = $response->json();
                $precipitation = $data['current']['precip'] ?? null;
                $uvi = $data['current']['uv_index'] ?? null;
            } else {
                Log::error($response->reason());
                Log::error($response->json()['message'] ?? null);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return [
            'service' => 'weatherstack',
            'precipitation' => $precipitation ?? null,
            'uvi' => $uvi ?? null,
        ];
    }
}
