<?php

namespace App\Http\Controllers;

use App\Models\TemperaturesMeasurements;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DiagramsController extends Controller
{
    public function getDiagram($stationName)
    {
        //TODO Pak de juiste info aka neem de API over zodat die weg kan.
        $allMeasurements = [
            [
                "name" => "100020",
                "longitude" => 6.367,
                "latitude" => 53.8,
                "elevation" => 6,
                "temperature" => 15,
                "humidity" => 20,
                "time" => "16:59:30",
                "date" => "2025-05-31"
            ],
            [
                "name" => "100040",
                "longitude" => 6.35,
                "latitude" => 54.167,
                "elevation" => 3,
                "temperature" => -7,
                "humidity" => 10,
                "time" => "16:59:30",
                "date" => "2025-05-31"
            ],
            [
                "name" => "100020",
                "longitude" => 5.367,
                "latitude" => 58.8,
                "elevation" => 7,
                "temperature" => 15,
                "humidity" => 28,
                "time" => "18:59:30",
                "date" => "2025-05-31"
            ],
            [
                "name" => "100060",
                "longitude" => 6.4,
                "latitude" => 53.9,
                "elevation" => 2,
                "temperature" => 12,
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
            'stations' => $this->getSelectedStationData($this->groupedStations($allMeasurements), "100020")
        ]);
    }


// Group raw stations by name
    function groupedStations(array $stations)
    {
        $groups = [];
        foreach ($stations as $station) {
//            $name = $station->name;
            $name = $station['name'];

            if (!isset($groups[$name]))
                $groups[$name] = [];

            $groups[$name][] = $station;

        }
        return $groups;
    }

    // from all the data only grab the data that is the same as the station name given in url
    function getSelectedStationData(array $stations, $stationName)
    {
        $selectedData = [];
        foreach ($stations as $station) {
            $name = $station['name'];

            if ($station['name'] === $stationName) {
                $selectedData[] = $station;

            }
        }
        return $selectedData;
    }
}

