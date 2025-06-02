<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemperaturesMeasurements extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'temperatures_measurements';
    public const NAME = 'name';
    public const LONGITUDE = 'longitude';
    public const LATITUDE = 'latitude';
    public const ELEVATION = 'elevation';
    public const TEMPERATURE = 'temperature';
    public const DATE = 'date';
    public const TIME = 'time';

    public $timestamps = false;
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        self::NAME,
        self::DATE,
        self::TIME,
        self::LONGITUDE,
        self::LATITUDE,
        self::ELEVATION,
        self::TEMPERATURE,
    ];

    public static function saveAsTempMeasurements(array $measurements): void
    {
        foreach ($measurements as $measurement) {
            $tempMeas = new TemperaturesMeasurements();
            $tempMeas[TemperaturesMeasurements::NAME] = $measurement->name;
            $tempMeas[TemperaturesMeasurements::DATE] = $measurement->date;
            $tempMeas[TemperaturesMeasurements::TIME] = $measurement->time;
            $tempMeas[TemperaturesMeasurements::TEMPERATURE] = $measurement->temperature;
            $tempMeas[TemperaturesMeasurements::LONGITUDE] = $measurement->longitude;
            $tempMeas[TemperaturesMeasurements::LATITUDE] = $measurement->latitude;
            $tempMeas[TemperaturesMeasurements::ELEVATION] = $measurement->elevation;
            $tempMeas->save();
        }
    }

    static function getTemperaturesMeasurementsOfToday(): array
    {
        return TemperaturesMeasurements::all()->where(self::DATE, now()->toDate())->all();
    }


    /**
     * Gets the temperatures of stations in south-america to the
     * @return array
     */
    static function getTemperaturesMeasurementsOfNow(): array
    {
        $currentHourTimes = [];

        $currentHour = now()->hour;
        $lastHour = $currentHour-1;
        $lastHourTime = date("$lastHour:i:s");
        $currentHourTime = date("$currentHour:i:s");

        $currentHourTimes[] = $lastHourTime;
        $currentHourTimes[] = $currentHourTime;

        return TemperaturesMeasurements::all()->where(self::DATE, now()->toDate())
            ->whereBetween(self::TIME, $currentHourTimes)->all();
    }

}
