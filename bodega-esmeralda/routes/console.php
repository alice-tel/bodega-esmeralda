<?php

use App\Console\Commands\QueryHumidityAndSaveToDatabaseCommand;
use App\Console\Commands\QueryTemperaturesAndSaveToDatabaseCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(QueryTemperaturesAndSaveToDatabaseCommand::class)->hourlyAt(47)->runInBackground();
Schedule::command(QueryHumidityAndSaveToDatabaseCommand::class)->daily()->at("02:00:00")->runInBackground();
//Schedule::command(QueryHumidityAndSaveToDatabaseCommand::class)->hourlyAt(15)->runInBackground(); // this one is for testing, so you can run it on the minute and not the hour

