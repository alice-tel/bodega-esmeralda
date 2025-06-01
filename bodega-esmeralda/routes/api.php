<!--this is for diagram fake data purposes-->
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Default example:
Route::middleware('api')->get('/user', function (Request $request) {
    return $request->user();
});

// chat gpt generated mumbo jumbo cuz i ddint want to type out the data

Route::get('/stations', function () {
    $stations = [];

    $stationNames = ['100020', '100040', '100060'];
    foreach ($stationNames as $name) {
        $data = [];

        for ($i = 0; $i < 24; $i++) {
            $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
            $minute = rand(0, 59);
            $second = rand(0, 59);

            $data[] = [
                'date' => date('Y-m-d'), // today's date
                'time' => "$hour:" . str_pad($minute, 2, '0', STR_PAD_LEFT) . ":" . str_pad($second, 2, '0', STR_PAD_LEFT),
                'temperature' => rand(-10, 35),
                'humidity' => rand(0, 100)
            ];
        }

        $stations[] = [
            'name' => $name,
            'longitude' => 6 + rand(300, 400) / 1000,
            'latitude' => 53 + rand(600, 800) / 1000,
            'elevation' => rand(1, 20),
            'data' => $data
        ];
    }

    return response()->json($stations);
});
