<?php

namespace App\Services;

use App\Models\City;
use App\Models\Country;
use Exception;

class CitiesService
{
    private string $path;
    private string $filename = 'worldcities.csv';

    public function __construct()
    {
        $this->path = base_path('app/Services/data/' . $this->filename);
    }

    /**
     * @throws Exception
     */
    public function getCities(): void
    {
        collect(json_decode($this->csvToJson($this->path)))->groupBy('iso2')->map(function ($cities, $group) {
            $country = Country::where('cca2', $group)->first();
            if($country) {
                $cities->map(function ($c) use ($country) {
                    City::firstOrCreate([
                        'external_id' => $c->id,
                    ], [
                        'country_id' => $country->id,
                        'name' => $c->city,
                        'name_ascii' => $c->city_ascii,
                        'capital' => $c->capital,
                        'population' => $c->population,
                        'lat' => $c->lat,
                        'lng' => $c->lng,
                    ]);
                });
            }
        });
    }

    protected function csvToJson($csvFilePath): false|string
    {
        if (!file_exists($csvFilePath)) {
            return json_encode(["error" => "File not found"]);
        }

        if (!is_readable($csvFilePath)) {
            return json_encode(["error" => "File is not readable"]);
        }

        $csvData = [];
        if (($handle = fopen($csvFilePath, 'r')) !== false) {
            $headers = fgetcsv($handle);
            while (($row = fgetcsv($handle)) !== false) {
                $csvData[] = array_combine($headers, $row);
            }
            fclose($handle);
        }

        return json_encode($csvData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
