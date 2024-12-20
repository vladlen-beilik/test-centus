<?php

namespace App\Console\Commands;

use App\Models\Alert;
use App\Models\City;
use App\Models\User;
use App\Notifications\WeatherNotification;
use App\Weather\WeatherServiceFactory;
use Illuminate\Console\Command;
use Exception;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @throws Exception
     */
    public function handle(): void
    {
//        $user = User::find(1);
//
//        $user->alerts->map(function ($alert) use ($user) {
//            $collection = collect(['accuweather','openweather', 'weatherstack'])->map(function ($serviceType) use ($alert) {
//                $weatherService = WeatherServiceFactory::createService($serviceType);
//                return $weatherService->getWeather($alert->city);
//            });
//
//            $user->notify(new WeatherNotification(
//                $alert->country->name,
//                $alert->city->name,
//                Alert::getPrecipitationLevel((float)$collection->avg('precipitation')),
//                Alert::getUviLevel($collection->avg('uvi'))
//            ));
//        });
    }
}
