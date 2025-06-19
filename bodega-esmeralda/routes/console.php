<?php

use App\Console\Commands\QueryHumidityAndSaveToDatabaseCommand;
use App\Console\Commands\QueryTemperaturesAndSaveToDatabaseCommand;
use App\Console\Commands\RemoveOldDataFromDatabaseCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(QueryTemperaturesAndSaveToDatabaseCommand::class)->hourlyAt(30)->runInBackground();
Schedule::command(QueryHumidityAndSaveToDatabaseCommand::class)->daily()->at("00:10:00")->runInBackground();
Schedule::command(RemoveOldDataFromDatabaseCommand::class)->daily()->at("00:00:10")->runInBackground();
