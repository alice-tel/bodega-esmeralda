<?php

use App\Models\TemperaturesMeasurements;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(TemperaturesMeasurements::TABLE_NAME, function (Blueprint $table) {
            $table->primary([TemperaturesMeasurements::NAME, TemperaturesMeasurements::DATE, TemperaturesMeasurements::TIME]);
            $table->string(TemperaturesMeasurements::NAME);
            $table->date(TemperaturesMeasurements::DATE);
            $table->time(TemperaturesMeasurements::TIME);
            $table->float(TemperaturesMeasurements::LONGITUDE);
            $table->float(TemperaturesMeasurements::LATITUDE);
            $table->float(TemperaturesMeasurements::ELEVATION);
            $table->float(TemperaturesMeasurements::TEMPERATURE);
            $table->string(TemperaturesMeasurements::LOCATION);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TEmperaturesMeasurements::TABLE_NAME);
    }
};
