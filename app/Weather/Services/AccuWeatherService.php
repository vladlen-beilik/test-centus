<?php

namespace App\Weather\Services;

use App\Models\City;
use App\Weather\WeatherServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class AccuWeatherService implements WeatherServiceInterface
{
    private string $host;
    private ?string $key;
    private string $version;
    private ?string $locationKey;

    public function __construct()
    {
        $this->host = 'dataservice.accuweather.com';
        $this->version = config('services.accuweather.api_version');
        $this->key = config('services.accuweather.api_key');

    }

    protected function getLocationKey(City $city): ?string
    {
        try {
            $response = Http::get("http://$this->host/locations/$this->version/cities/geoposition/search", [
                'q' => "$city->lat,$city->lng",
                'apikey' => $this->key
            ]);
            if($response->successful()) {
                return $response->json()['Key'] ?? null;
            } else {
                Log::error($response->json());
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        return null;
    }

    public function getWeather(City $city): array
    {
        $this->locationKey = $this->getLocationKey($city);

        try {
            $response = Http::get("http://$this->host/currentconditions/$this->version/$this->locationKey", [
                'details' => 'true',
                'apikey' => $this->key
            ]);

            if($response->successful()) {
                $data = $response->json();
                $precipitation = $data[0]['PrecipitationSummary']['Precipitation']['Metric']['Value'] ?? null;
                $uvi = $data[0]['UVIndex'] ?? null;
            } else {
                Log::error($response->json());
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return [
            'service' => 'accuweather',
            'precipitation' => $precipitation ?? null,
            'uvi' => $uvi ?? null,
        ];
    }
}
