<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class HumidityMeasurements extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'humidity_measurements';
    public const NAME = 'name';
    public const LONGITUDE = 'longitude';
    public const LATITUDE = 'latitude';
    public const ELEVATION = 'elevation';
    public const HUMIDITY = 'humidity';
    public const LOCATION = 'location';
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
        self::HUMIDITY,
        self::LOCATION,
    ];

    public static function saveAsHumidityMeasurements(array $measurements): void
    {
        foreach ($measurements as $measurement) {
            $tempMeas = new HumidityMeasurements();
            $tempMeas[HumidityMeasurements::NAME] = $measurement->name;
            $tempMeas[HumidityMeasurements::DATE] = $measurement->date;
            $tempMeas[HumidityMeasurements::TIME] = $measurement->time;
            $tempMeas[HumidityMeasurements::HUMIDITY] = $measurement->humidity;
            $tempMeas[HumidityMeasurements::LONGITUDE] = $measurement->longitude;
            $tempMeas[HumidityMeasurements::LATITUDE] = $measurement->latitude;
            $tempMeas[HumidityMeasurements::ELEVATION] = $measurement->elevation;
            $tempMeas[HumidityMeasurements::LOCATION] = $measurement->location;
            $tempMeas->save();
        }
    }

    private static function getHumidityMeasurementsOfToday(): array
    {
        return HumidityMeasurements::all()->where(self::DATE, now()->toDateString())->all();
    }
    public static function getHumidityMeasurementsOfTodayAndStation(string $stationName): array
    {
        return HumidityMeasurements::all()->where(self::NAME, $stationName)->where(self::DATE, now()->toDateString())->all();
    }

    public static function getHumidityAverageOfStationsOfToday(): array
    {
        $groupedStations = self::getHumMeasurementsOfTodayGroupedByStation();
        return array_map(function ($groupedStation) {
            $total = array_reduce($groupedStation, function ($carry, $item) {
                return $carry + $item[HumidityMeasurements::HUMIDITY];
            }, 0);
            $stationName = $groupedStation[0][HumidityMeasurements::NAME];
            $stationLocation = $groupedStation[0][HumidityMeasurements::LOCATION];
            $average = round($total/count($groupedStation), 2);
            return [self::NAME => $stationName, self::LOCATION => $stationLocation, 'average' => $average];
        }, $groupedStations);
    }

    private static function getHumMeasurementsOfTodayGroupedByStation(): array
    {
        $groupedStations = [];
        foreach (HumidityMeasurements::getHumidityMeasurementsOfToday() as $humidityMeasurement) {
            $stationName = $humidityMeasurement[HumidityMeasurements::NAME];
            $groupedStations[$stationName][] = $humidityMeasurement;
        }
        return $groupedStations;
    }
    public static function removeOldData(string $lastValidDate): void
    {
        HumidityMeasurements::where(self::DATE, "<" , $lastValidDate)->delete();
    }

}
