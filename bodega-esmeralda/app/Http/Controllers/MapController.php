<?php

namespace App\Http\Controllers;

use App\Models\TemperaturesMeasurements;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class MapController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show(): Response
    {
        $datePerStation = TemperaturesMeasurements::getTemperaturesOfTodayLatestUnique();
//        Log::info(print_r($datePerStation,true));
        return Inertia::render('Map', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'stations' => $datePerStation,
        ]);
    }
}
