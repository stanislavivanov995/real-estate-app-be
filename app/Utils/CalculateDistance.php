<?php

namespace App\Utils;


trait CalculateDistance
{
    public function distance($estate, $request)
    {
        $earthRadius = 6371;

        $lat1 = $request->latitude;
        $lon1 = $request->longitude;
        $lat2 = $estate->latitude;
        $lon2 = $estate->longitude;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c;

        return $distance;
    }
}
