<?php

namespace App\Http\Controllers;

use App\Models\HumidityMeasurements;
use App\Models\TemperaturesMeasurements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GraphsController extends Controller
{
    private const HOURS_ARRAY = [ '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23' ];

    private function getLocationName($latitude, $longitude)
    {
        $cacheKey = 'location_' . $latitude . '_' . $longitude;

        return Cache::rememberForever($cacheKey, function () use ($latitude, $longitude) {
            try {
                $response = Http::withHeaders([
                    'User-Agent' => 'BodegaEsmeralda/1.0 (your-email@example.com)' // Replace with your actual application name and email
                ])->get("https://nominatim.openstreetmap.org/reverse", [
                    'format' => 'json',
                    'lat' => $latitude,
                    'lon' => $longitude,
                    'zoom' => 10,
                    'addressdetails' => 1
                ]);

                if ($response->successful()) {
                    $data = $response->json();

                    if (isset($data['address'])) {
                        $address = $data['address'];
                        $primaryLocation = $address['city'] ?? $address['village'] ?? $address['state'] ?? null;
                        $country = $address['country'] ?? null;

                        if ($primaryLocation && $country) {
                            return $primaryLocation . ', ' . $country;
                        } elseif ($primaryLocation) {
                            return $primaryLocation;
                        } elseif ($country) {
                            return $country;
                        } else {
                            return $data['display_name'] ?? 'Unknown Location';
                        }
                    } else {
                        Log::warning('Nominatim API response successful but missing address for lat:' . $latitude . ', lon:' . $longitude . '. Response: ' . json_encode($data));
                    }
                } else {
                    Log::error('Nominatim API request failed for lat:' . $latitude . ', lon:' . $longitude . '. Status:' . $response->status() . ', Body: ' . $response->body());
                }
            } catch (\Exception $e) {
                Log::error('Geocoding exception for lat:' . $latitude . ', lon:' . $longitude . '. Message: ' . $e->getMessage());
            }

            return 'Unknown Location';
        });
    }

    private const temperaturesOptions = [
        "responsive" => true,
        "maintainAspectRatio" => false,
        "plugins" => [
            "title" => [
                "text" => "Temperatures",
                "display" => false,
                "font" => [
                    "size" => 12,
                    "weight" => "bold"
                ],
                "align" => "start",
                "padding" => [
                    "top" => 10,
                    "left" => 10
                ]
            ],
            "legend" => [
                "position" => "top",
                "labels" => [
                    "font" => [
                        "size" => 12
                    ]
                ]
            ],
            "tooltip" => [
                "backgroundColor" => "#2b394E",
                "titleColor" => "#ffffff",
                "bodyColor" => "#ffffff",
                "padding" => 10,
                "cornerRadius" => 4
            ]
        ],
        "scales" => [
            "y" => [
                "beginAtZero" => true,
                "title" => [
                    "display" => true,
                    "text" => "Temperature (°C)",
                    "font" => [
                        "size" => 12
                    ]
                ],
                "ticks" => [
                    "font" => [
                        "size" => 12
                    ]
                ],
                "grid" => [
                    "display" => false
                ]
            ],
            "x" => [
                "title" => [
                    "display" => true,
                    "text" => "Hour",
                    "font" => [
                        "size" => 12
                    ]
                ],
                "ticks" => [
                    "font" => [
                        "size" => 12
                    ]
                ],
                "grid" => [
                    "display" => false
                ]
            ]
        ],
        "elements" => [
            "bar" => [
                "borderRadius" => 8,
                "borderWidth" => 2,
                "borderColor" => "#CF1F25"
            ]
        ],
        "animation" => [
            "duration" => 2000,
            "easing" => "easeInOutQuart",
            "onProgress" => "function(animation) {
                animation.chart.update('none');
            }",
            "onComplete" => "function(animation) {
                animation.chart.update('none');
            }"
        ],
        "hover" => [
            "animationDuration" => 400
        ],
        "responsiveAnimationDuration" => 500
    ];

    private const humiditiesOptions = [
        "responsive" => true,
        "maintainAspectRatio" => false,
        "plugins" => [
            "title" => [
                "text" => "Humidity",
                "display" => false,
                "font" => [
                    "size" => 12,
                    "weight" => "bold"
                ],
                "align" => "start",
                "padding" => [
                    "top" => 10,
                    "left" => 10
                ]
            ],
            "legend" => [
                "position" => "top",
                "labels" => [
                    "font" => [
                        "size" => 12
                    ]
                ]
            ],
            "tooltip" => [
                "backgroundColor" => "#2b394E",
                "titleColor" => "#ffffff",
                "bodyColor" => "#ffffff",
                "padding" => 10,
                "cornerRadius" => 4
            ]
        ],
        "scales" => [
            "y" => [
                "beginAtZero" => true,
                "title" => [
                    "display" => true,
                    "text" => "Humidity (%)",
                    "font" => [
                        "size" => 12
                    ]
                ],
                "ticks" => [
                    "font" => [
                        "size" => 12
                    ]
                ],
                "grid" => [
                    "display" => false
                ]
            ],
            "x" => [
                "title" => [
                    "display" => true,
                    "text" => "Hour",
                    "font" => [
                        "size" => 12
                    ]
                ],
                "ticks" => [
                    "font" => [
                        "size" => 12
                    ]
                ],
                "grid" => [
                    "display" => false
                ]
            ]
        ],
        "elements" => [
            "bar" => [
                "borderRadius" => 8,
                "borderWidth" => 2,
                "borderColor" => "#2b394E"
            ]
        ],
        "animation" => [
            "duration" => 2000,
            "easing" => "easeInOutQuart",
            "onProgress" => "function(animation) {
                animation.chart.update('none');
            }",
            "onComplete" => "function(animation) {
                animation.chart.update('none');
            }"
        ],
        "hover" => [
            "animationDuration" => 400
        ],
        "responsiveAnimationDuration" => 500
    ];

    public function getGraph($stationName)
    {



        //TODO Pak de juiste info aka neem de API over zodat die weg kan.
        $allTempMeasurements = TemperaturesMeasurements::getTemperaturesMeasurementsOfTodayAndStationArray($stationName);
        $allHumMeasurements = HumidityMeasurements::getHumidityMeasurementsOfTodayAndStation($stationName); //$this->fillArray($this->getAttributeValues($avergedDataPerHour, "humidity"), 24);

        $locationName = isset($allTempMeasurements[0]) ? $allTempMeasurements[0][TemperaturesMeasurements::LOCATION] : 'Unknown Location';

        $temperatures = $this->getGroupedAveragedStationData($allTempMeasurements, $stationName, "temperature");
        $humidities = $this->getGroupedAveragedStationData($allHumMeasurements, $stationName, "humidity");

        $temperaturesData = $this->getLabelData('Temperature', '#CF1F25', $temperatures);
        $humiditiesData = $this->getLabelData('Humidity', '#2b394E', $humidities);

        return Inertia::render('Graph', [
            'temperaturesData' => $temperaturesData,
            'temperaturesOptions' => self::temperaturesOptions,
            'humiditiesData' => $humiditiesData,
            'humiditiesOptions' => self::humiditiesOptions,
            'stationName' => $stationName,
            'locationName' => $locationName,
        ]);
    }

    function getLabelData($title, $color, $data): array
    {
        return [
            "labels" => self::HOURS_ARRAY,
            "datasets" => [
                [
                    "label" => $title,
                    'backgroundColor' => $color,
                    "data" => $data
                ]
            ]
        ];
    }

    function getGroupedAveragedStationData($allMeasurements, $stationName, $dataName): array
    {
        $stationData = $this->getSelectedStationData($allMeasurements, $stationName);
        $dataPerHour = $this->combinePerHour($stationData, $dataName);
        $avergedDataPerHour = $this->avarigeData($dataPerHour, $dataName);
        return $this->fillArray($this->getAttributeValues($avergedDataPerHour, $dataName), 24);
    }

// Group raw stations by name
    function groupedStations(array $stations)
    {
        $groups = [];
        foreach ($stations as $station) {
//            $name = $station->name;
            $name = $station['name'];

            if (!isset($groups[$name]))
                $groups[$name] = [];

            $groups[$name][] = $station;

        }
        return $groups;
    }

    // from all the data only grab the data that is the same as the station name given in url
    function getSelectedStationData(array $stations, $stationName)
    {
        $selectedData = [];
        foreach ($stations as $station) {
            $name = $station['name'];

            if ($name === $stationName) {
                $selectedData[] = $station;

            }
        }
        return $selectedData;
    }

    function combinePerHour($data, $dataName): array
    {
        $hourlyData = [];

        foreach ($data as $entry) {
            $time = $entry['time'];
            $hour = substr($time, 0, 2);

            if (!isset($hourlyData[$hour])) {
                $hourlyData[$hour] = [
                    'total_val' => 0,
                    'count' => 0
                ];
            }

            $hourlyData[$hour]['total_val'] += $entry[$dataName];
            $hourlyData[$hour]['count'] += 1;
        }
        return $hourlyData;
    }

    function avarigeData($hourlyData, $dataName)
    {
        $filteredData = [];

        foreach ($hourlyData as $hour => $data) {
//            print_r($data);
            $filteredData[] = [
                'hour' => $hour,
                $dataName => round($data['total_val'] / $data['count'], 2),
            ];
        }
        return $filteredData;
    }

    function getAttributeValues($data, $attribute): array
    {
        $attributeValues = [];
        foreach ($data as $hourData){
             $attributeValues[(int)$hourData["hour"]] = $hourData[$attribute];
        }
        return $attributeValues;
    }

    function fillArray($data, $count):array
    {
        $values = [];
        for ($i = 0; $i < $count; $i++) {
            $value = $data[$i] ?? 0;
            $values[] = $value;
        }
        return $values;
    }


}


