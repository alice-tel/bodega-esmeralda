<?php

namespace App\Http\Controllers;

use App\Models\HumidityMeasurements;
use App\Models\TemperaturesMeasurements;
use App\Services\QueryService;

class ApiTestController extends Controller
{
    public function __construct(
        protected QueryService $queryer,
    ) {}

    public function test()
    {
//        $this->queryer->login();
//        $result = $this->queryer->queryTemperaturesOfCurrentDayAndHour();
//
////        $this->queryer->login();
////        $result = $this->queryer->query(10);
//        $this->queryer->logout();
        return print_r(HumidityMeasurements::getHumidityAverageOfStationsOfToday(), true);
//        return print_r(HumidityMeasurements::getHumidityAverageOfStations(), true);
    }
}
