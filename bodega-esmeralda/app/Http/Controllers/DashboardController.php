<?php

namespace App\Http\Controllers;

use App\Models\HumidityMeasurements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class DashboardController extends Controller
{

    public function getData()
    {
        $stations = ["100020" =>
            [
                "name" => "100020",
                "longitude" => 6.367,
                "latitude" => 53.8,
                "elevation" => 6,
                "tempurture" => 15,
                "humidity" => 20,
                "time" => "16:59:30",
                "date" => "2025-05-31"
            ], "100040" =>
            [
                "name" => "100040",
                "longitude" => 6.367,
                "latitude" => 53.8,
                "elevation" => 6,
                "tempurture" => 15,
                "humidity" => 40,
                "time" => "16:59:30",
                "date" => "2025-05-31"
            ], "100060" =>
            [
                "name" => "100060",
                "longitude" => 6.367,
                "latitude" => 53.8,
                "elevation" => 6,
                "tempurture" => 15,
                "humidity" => 60,
                "time" => "16:59:30",
                "date" => "2025-05-31"
            ], "100070" =>
            [
                "name" => "100070",
                "longitude" => 6.367,
                "latitude" => 53.8,
                "elevation" => 6,
                "tempurture" => 15,
                "humidity" => 70,
                "time" => "16:59:30",
                "date" => "2025-05-31"
            ], "100080" =>
            [
                "name" => "100080",
                "longitude" => 6.367,
                "latitude" => 53.8,
                "elevation" => 6,
                "tempurture" => 15,
                "humidity" => 80,
                "time" => "16:59:30",
                "date" => "2025-05-31"
            ]
        ];

//        $stations = array_values($Fakedata);

        // brian zei gebruik laravel functie hiervoor dus heb deze gechatgpt
        usort($stations, fn($a, $b) => $b['humidity'] <=> $a['humidity']);

        //zit zegt momenteel top5, zodra er meer info is maken we hier top10 van (dit doe je door t laatste nummer in de volgende variabele aan te passen
        $top5 = array_slice($stations, 0, 5);

        return $top5;
    }

    public function index()
    {
        $topStations = $this->getData();

        return Inertia::render('Dashboard', [
            'topStations' => $topStations
        ]);
    }

}
