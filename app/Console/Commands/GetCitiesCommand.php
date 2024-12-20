<?php

namespace App\Console\Commands;

use App\Services\CitiesService;
use Illuminate\Console\Command;
use Exception;

class GetCitiesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-cities';

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
        $service = new CitiesService();
        $service->getCities();
    }
}
