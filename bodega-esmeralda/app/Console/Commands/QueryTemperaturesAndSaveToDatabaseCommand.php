<?php

namespace App\Console\Commands;

use App\Models\TemperaturesMeasurements;
use App\Services\QueryService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class QueryTemperaturesAndSaveToDatabaseCommand extends Command
{
    protected $signature = 'query-save:temperatures {time}';


    public function handle(QueryService $service){
        $service->login();
        $timeArg = $this->argument('time');
        $response = null;
        if ($timeArg != null || $timeArg != '' ) {
            $response = $service->queryTemperaturesOfCurrentDayWithHour($timeArg);
        } else {
            $response = $service->queryTemperaturesOfCurrentDayAndHour();
        }
        $measurements = json_decode($response);
        TemperaturesMeasurements::saveAsTempMeasurements($measurements);
    }
}
