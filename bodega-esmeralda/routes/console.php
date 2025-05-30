<?php

use App\Services\QueryService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function (QueryService $service) {
    $service->query(QueryService::HUMIDITY_ID);
})->daily()->at('03:00');
