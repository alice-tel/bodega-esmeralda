<?php

namespace App\Console\Commands;

use App\Models\TemperaturesMeasurements;
use App\Services\QueryService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class QueryTemperaturesAndSaveToDatabaseCommand extends Command
{
    protected $signature = 'query-save:temperatures';

    public function handle(QueryService $service){
        $service->login();
        $response = $service->queryTemperaturesOfCurrentDayAndHour();
        $measurements = json_decode($response);
        Log::info(print_r($measurements, true));
        TemperaturesMeasurements::saveAsTempMeasurements($measurements);
    }
}
