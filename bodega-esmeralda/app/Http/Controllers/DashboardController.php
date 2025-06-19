<?php

namespace App\Http\Controllers;

use App\Models\HumidityMeasurements;
use App\Models\TemperaturesMeasurements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{

    public function geAverageSortedData(): array
    {

        $stations = HumidityMeasurements::getHumidityAverageOfStationsOfToday();
        Log::info(print_r($stations, true));
        usort($stations, fn($a, $b) => $b['average'] <=> $a['average']);

        return array_slice($stations, 0, 10);
    }

    public function index()
    {
        $topStations = $this->geAverageSortedData();
        $datePerStation = TemperaturesMeasurements::getTemperaturesOfNowLatestUnique();
        return Inertia::render('Dashboard', [
            'topStations' => $topStations,
            'stations' => $datePerStation,
        ]);
    }

}
