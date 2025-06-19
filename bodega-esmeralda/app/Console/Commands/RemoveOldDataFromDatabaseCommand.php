<?php

namespace App\Console\Commands;

use App\Models\HumidityMeasurements;
use App\Models\TemperaturesMeasurements;
use App\Services\QueryService;
use http\QueryString;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RemoveOldDataFromDatabaseCommand extends Command
{
    protected $signature = 'bodega:remove-old-data';
    private const MAX_OLD_DATA_WEEKS = 4;

    public function handle(){

        $oldDataDate = now()->subWeeks(self::MAX_OLD_DATA_WEEKS)->toDateString();

        HumidityMeasurements::removeOldData($oldDataDate);
        TemperaturesMeasurements::removeOldData($oldDataDate);
    }
}
