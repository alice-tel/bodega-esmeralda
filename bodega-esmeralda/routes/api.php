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
    return response()->json([
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
            "name" => "100020",
            "longitude" => 6.35,
            "latitude" => 54.167,
            "elevation" => 3,
            "tempurture" => -15,
            "humidity" => 20,
            "time" => "17:59:30",
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
        "name" => "100040",
        "longitude" => 6.35,
        "latitude" => 54.167,
        "elevation" => 3,
        "tempurture" => -15,
        "humidity" => 20,
        "time" => "17:59:30",
        "date" => "2025-05-31"
    ]
    ]);
});
