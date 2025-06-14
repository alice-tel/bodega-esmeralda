<?php

namespace App\Console\Commands;

use App\Models\TemperaturesMeasurements;
use App\Services\QueryService;
use http\QueryString;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class QueryTemperaturesAndSaveToDatabaseCommand extends Command
{
    protected $signature = 'query-save:temperatures {--time=}';


    public function handle(QueryService $service){
        $service->login();

        $response = $this->queryToServer($service);
        $measurements = json_decode($response);
        TemperaturesMeasurements::saveAsTempMeasurements($measurements);
    }

    private function queryToServer(QueryService $service): string
    {
        if ($this->hasArgument('time')) {
            $timeArg = $this->argument('time');
            return $service->queryTemperaturesOfCurrentDayWithHour($timeArg);
        } else {
            return $service->queryTemperaturesOfCurrentDayAndHour();
        }
    }
}
