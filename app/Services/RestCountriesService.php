<?php

namespace App\Services;

use App\Models\Country;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class RestCountriesService
{
    private ?string $version;
    private string $domain = 'https://restcountries.com';

    public function __construct()
    {
        $this->version = config('services.rest_countries.api_version');
    }

    /**
     * @throws Exception
     */
    public function getCountries(): void
    {
        $response = Http::get("$this->domain/$this->version/all", [
            'fields' => 'name,flags,latlng,cca2'
        ]);

        if ($response->ok()) {
            try {
                collect($response->json())->map(function ($c) {
                    Country::firstOrCreate([
                        'cca2' => $c['cca2'],
                    ], [
                        'name' => $c['name']['common'],
                        'icon' => $this->saveSVG($c),
                        'lat' => $c['latlng'][0],
                        'lng' => $c['latlng'][1],
                    ]);
                });
            } catch (Exception $e) {}
        }
    }

    protected function saveSVG($country): ?string
    {
        if($country['flags']['svg'] ?? null) {
            $response = Http::get($country['flags']['svg']);
            if ($response->successful()) {
                $svgContent = $response->body();
                $basename = basename($country['flags']['svg']);
                Storage::put("countries/$basename", $svgContent);
                return "countries/$basename";
            }
            return null;
        }
        return null;
    }
}
