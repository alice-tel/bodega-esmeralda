<?php

namespace App\Console\Commands;

use App\Models\HumidityMeasurements;
use App\Models\TemperaturesMeasurements;
use App\Services\QueryService;
use http\QueryString;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class QueryHumidityAndSaveToDatabaseCommand extends Command
{
    protected $signature = 'query-save:humidity';


    public function handle(QueryService $service){
        $service->login();
        $response = $service->queryHumidityOfCurrentDay();
        Log::info(json_encode($response));
        $measurements = json_decode($response);
        HumidityMeasurements::saveAsHumidityMeasurements($measurements);
    }
}
