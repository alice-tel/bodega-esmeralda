<?php

namespace App\Http\Controllers;

use App\Models\HumidityMeasurements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    //ik maak deze ff uit mijn hoofd terwijl mijn update bezig gaan, dus als t dom eruit ziet t is omdat ik t niet kan testen.
    public function getData(){
        $data = HumidityMeasurements::getHumidityAverageOfStationsOfToday();
        Log::info(print_r($data, true));
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

    //comebine the data per hour so that an avarge for the day can be calculated, The function may have to be reworked because idk if it will work well with multiple stations
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
}
