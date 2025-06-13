<?php

use App\Models\HumidityMeasurements;
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
        Schema::create(HumidityMeasurements::TABLE_NAME, function (Blueprint $table) {
            $table->primary([HumidityMeasurements::NAME, HumidityMeasurements::DATE, HumidityMeasurements::TIME]);
            $table->string(HumidityMeasurements::NAME);
            $table->date(HumidityMeasurements::DATE);
            $table->time(HumidityMeasurements::TIME);
            $table->float(HumidityMeasurements::LONGITUDE);
            $table->float(HumidityMeasurements::LATITUDE);
            $table->float(HumidityMeasurements::ELEVATION);
            $table->float(HumidityMeasurements::HUMIDITY);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(HumidityMeasurements::TABLE_NAME);
    }
};
