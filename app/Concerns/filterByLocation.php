<?php

namespace App\Concerns;
use Illuminate\Http\Request;


trait filterByLocation
{
    protected $request;


    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function distance($estate)
    {
        $earthRadius = 6371;

        $lat1 = $this->request->latitude;
        $lon1 = $this->request->longitude;
        $lat2 = $estate->latitude;
        $lon2 = $estate->longitude;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c;

        return $distance;
    }

    public function filterByLocation($estates)
    {      
        if ($this->request->filled('latitude') && $this->request->filled('longitude')) {

            $estates = collect($estates->filter(
                function ($estate) {
                $radius = $this->request->query('radius', 0);

                return $this->distance($estate, $this->request) <= $radius;
            }));
        }

        return $estates;
    }
}