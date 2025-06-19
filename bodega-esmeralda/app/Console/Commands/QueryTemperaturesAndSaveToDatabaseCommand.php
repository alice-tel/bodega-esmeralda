<?php

namespace App\Console\Commands;

use App\Models\TemperaturesMeasurements;
use App\Services\QueryService;
use http\QueryString;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class QueryTemperaturesAndSaveToDatabaseCommand extends Command
{
    protected $signature = 'query-save:temperatures {--all=} {--time=}';


    public function handle(QueryService $service){
        $service->login();

        if ($this->hasOption('all')){
            for ($i=0; $i < 24; $i++){
                $timeOption = sprintf("%02d", $i);
                $this->querySave($service, $timeOption);
            }
        }
        else{
            $timeOption = $this->hasOption('time') ? $this->option('time') : null;
            $this->querySave($service, $timeOption);
        }
    }

    private function querySave($service, $timeOption = null)
    {
        $response = $this->queryToServer($service, $timeOption);
        $measurements = json_decode($response);
        TemperaturesMeasurements::saveAsTempMeasurements($measurements);
    }
    private function queryToServer(QueryService $service, $timeOption = null): string
    {
        if ($timeOption != null) {
            return $service->queryTemperaturesOfCurrentDayWithHour($timeOption);
        } else {
            return $service->queryTemperaturesOfCurrentDayAndHour();
        }
    }
}
