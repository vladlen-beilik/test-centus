<?php

namespace App\Console\Commands;

use App\Services\RestCountriesService;
use Illuminate\Console\Command;
use Exception;

class GetCountriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-countries';

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
        $service = new RestCountriesService();
        $service->getCountries();
    }
}
