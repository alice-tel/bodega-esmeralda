<?php

namespace App\Http\Controllers;

use App\Models\TemperaturesMeasurements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class GraphsController extends Controller
{
    private const HOURS_ARRAY = [ '00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23' ];

    private const temperaturesOptions = [
        "responsive" => true,
        "plugins" => [ "title" => [ "text" => "Temperatures", "display" => true ] ],
    ];
    private const humiditiesOptions = [
        "responsive" => true,
        "plugins" => [ "title" => [ "text" => "Humidity", "display" => true ] ],
    ];

    public function getGraph($stationName)
    {
        //TODO Pak de juiste info aka neem de API over zodat die weg kan.
        $allMeasurements = TemperaturesMeasurements::getTemperaturesMeasurementsOfTodayAndStationArray($stationName);
        Log::info(print_r($allMeasurements, true));
        //TODO Daarna stap gewijs de html leger en leger maken.
        $stationData = $this->getSelectedStationData($allMeasurements, $stationName);
        $dataPerHour = $this->combinePerHour($stationData);
        $avergedDataPerHour = $this->avarigeData($dataPerHour);
        $temperatures = $this->fillArray($this->getAttributeValues($avergedDataPerHour, "temperature"), 24);
        $humidities = $this->fillArray($this->getAttributeValues($avergedDataPerHour, "humidity"), 24);


        $temperaturesData = [
            "labels" => self::HOURS_ARRAY,


            "datasets" => [ [ "label" => 'Temperature', 'backgroundColor' => '#dd1100', "data" => $temperatures ] ]
        ];
        $humiditiesData = [
            "labels" => self::HOURS_ARRAY,
            "datasets" => [ [ "label" => 'Humidity', 'backgroundColor' => '#0011dd',"data" => $humidities ] ]
        ];



//        return view('Diagrams');
        return Inertia::render('Graph', [
            'temperaturesData' => $temperaturesData,
            'temperaturesOptions' => self::temperaturesOptions,
            'humiditiesData' => $humiditiesData,
            'humiditiesOptions' => self::humiditiesOptions,
            'stationName' => $stationName,
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

            if ($name === $stationName) {
                $selectedData[] = $station;

            }
        }
        return $selectedData;
    }

    function combinePerHour($data): array
    {
        $hourlyData = [];

        foreach ($data as $entry) {
            $time = $entry['time'];
            $hour = substr($time, 0, 2);

            if (!isset($hourlyData[$hour])) {
                $hourlyData[$hour] = [
                    'total_temp' => 0,
                    'total_humidity' => 0,
                    'count' => 0
                ];
            }

            $hourlyData[$hour]['total_temp'] += $entry['temperature'];
            $hourlyData[$hour]['total_humidity'] += $entry['humidity'];
            $hourlyData[$hour]['count'] += 1;
        }
        return $hourlyData;
    }

    function avarigeData($hourlyData)
    {
        $filteredData = [];

        foreach ($hourlyData as $hour => $data) {
//            print_r($data);
            $filteredData[] = [
                'hour' => $hour,
                'temperature' => round($data['total_temp'] / $data['count'], 2),
                'humidity' => round($data['total_humidity'] / $data['count'], 2),
            ];
        }
        return $filteredData;
    }

    function getAttributeValues($data, $attribute): array
    {
        $attributeValues = [];
        foreach ($data as $hourData){
             $attributeValues[(int)$hourData["hour"]] = $hourData[$attribute];
        }
        return $attributeValues;
    }

    function fillArray($data, $count):array
    {
        $values = [];
        for ($i = 0; $i < $count; $i++) {
            $value = $data[$i] ?? 0;
            $values[] = $value;
        }
        return $values;
    }


}


