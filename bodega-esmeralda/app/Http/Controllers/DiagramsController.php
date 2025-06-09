<?php

namespace App\Http\Controllers;

use App\Models\TemperaturesMeasurements;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DiagramsController extends Controller
{
    public function getDiagram()
    {
        //TODO Pak de juiste info aka neem de API over zodat die weg kan.
        $allMeasurements = [
            [
                "name" => "100020",
                "longitude" => 6.367,
                "latitude" => 53.8,
                "elevation" => 6,
                "tempurture" => 15,
                "humidity" => 20,
                "time" => "16:59:30",
                "date" => "2025-05-31"
            ],
            [
                "name" => "100040",
                "longitude" => 6.35,
                "latitude" => 54.167,
                "elevation" => 3,
                "tempurture" => -7,
                "humidity" => 10,
                "time" => "16:59:30",
                "date" => "2025-05-31"
            ],
            [
                "name" => "100060",
                "longitude" => 6.4,
                "latitude" => 53.9,
                "elevation" => 2,
                "tempurture" => 12,
                "humidity" => 30,
                "time" => "16:59:30",
                "date" => "2025-05-31"
            ]
        ];

//        return response()->json($allMeasurements);
//        return $allMeasurements;
        //TODO Daarna stap gewijs de html leger en leger maken.

//        return view('Diagrams');
        return Inertia::render('Diagrams', [
            'stations' => $allMeasurements
        ]);
    }


// Group raw stations by name
    function groupedStations($stations)
    {
        $groups = [];
        foreach ($stations as $station) {
            $name = $station->name;
            if (!isset($stations[$name]))
                $groups[$name] = [];

            $groups[$name][] = $station;

        }
        return $groups;
    }
}

