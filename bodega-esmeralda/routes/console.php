<?php

use App\Console\Commands\QueryTemperaturesAndSaveToDatabaseCommand;
use App\Models\TemperaturesMeasurements;
use App\Services\QueryService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(QueryTemperaturesAndSaveToDatabaseCommand::class)->hourlyAt(17)->runInBackground();

