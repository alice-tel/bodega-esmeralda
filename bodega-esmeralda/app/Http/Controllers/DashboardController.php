<?php

namespace App\Http\Controllers;

use App\Models\HumidityMeasurements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
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

    public function getData()
    {
        $stations = [
            "100020" => [
                "name" => "100020",
                "longitude" => -68.1193,  // La Paz, Bolivia
                "latitude" => -16.4897,
                "elevation" => 3640,
                "tempurture" => 12,
                "humidity" => 70,
                "time" => "16:59:30",
                "date" => "2025-05-31"
            ],
            "100040" => [
                "name" => "100040",
                "longitude" => -55.7821,  // Montevideo, Uruguay
                "latitude" => -34.9011,
                "elevation" => 43,
                "tempurture" => 20,
                "humidity" => 78,
                "time" => "16:59:30",
                "date" => "2025-05-31"
            ],
            "100060" => [
                "name" => "100060",
                "longitude" => -60.0217,  // Manaus, Brazil
                "latitude" => -3.1190,
                "elevation" => 92,
                "tempurture" => 28,
                "humidity" => 85,
                "time" => "16:59:30",
                "date" => "2025-05-31"
            ],
            "100070" => [
                "name" => "100070",
                "longitude" => -66.9188,  // Caracas, Venezuela
                "latitude" => 10.4806,
                "elevation" => 900,
                "tempurture" => 26,
                "humidity" => 70,
                "time" => "16:59:30",
                "date" => "2025-05-31"
            ],
            "100080" => [
                "name" => "100080",
                "longitude" => -78.4678,  // Quito, Ecuador
                "latitude" => -0.1807,
                "elevation" => 2850,
                "tempurture" => 16,
                "humidity" => 75,
                "time" => "16:59:30",
                "date" => "2025-05-31"
            ],
            "100090" => [
                "name" => "100090",
                "longitude" => -71.4925,  // Cusco, Peru
                "latitude" => -13.5320,
                "elevation" => 3399,
                "tempurture" => 14,
                "humidity" => 60,
                "time" => "16:59:30",
                "date" => "2025-05-31"
            ],
            "100100" => [
                "name" => "100100",
                "longitude" => -58.3816,  // Buenos Aires, Argentina
                "latitude" => -34.6037,
                "elevation" => 25,
                "tempurture" => 22,
                "humidity" => 65,
                "time" => "16:59:30",
                "date" => "2025-05-31"
            ],
            "100110" => [
                "name" => "100110",
                "longitude" => -70.6483,  // Santiago, Chile
                "latitude" => -33.4489,
                "elevation" => 520,
                "tempurture" => 18,
                "humidity" => 45,
                "time" => "16:59:30",
                "date" => "2025-05-31"
            ],
            "100120" => [
                "name" => "100120",
                "longitude" => -46.6333,  // São Paulo, Brazil
                "latitude" => -23.5505,
                "elevation" => 760,
                "tempurture" => 25,
                "humidity" => 75,
                "time" => "16:59:30",
                "date" => "2025-05-31"
            ],
            "100130" => [
                "name" => "100130",
                "longitude" => -74.0721,  // Bogotá, Colombia
                "latitude" => 4.7110,
                "elevation" => 2640,
                "tempurture" => 15,
                "humidity" => 70,
                "time" => "16:59:30",
                "date" => "2025-05-31"
            ]
        ];

        // Add location names to each station
        foreach ($stations as &$station) {
            $station['location_name'] = $this->getLocationName($station['latitude'], $station['longitude']);
        }

        usort($stations, fn($a, $b) => $b['humidity'] <=> $a['humidity']);

        $top10 = array_slice($stations, 0, 10);

        return $top10;
    }

    public function index()
    {
        $topStations = $this->getData();

        return Inertia::render('Dashboard', [
            'topStations' => $topStations
        ]);
    }

}
