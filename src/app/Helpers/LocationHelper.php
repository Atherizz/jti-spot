<?php

namespace App\Helpers;

class LocationHelper
{
    /**
     * Calculate the great-circle distance between two points on the Earth surface.
     *
     * @param float|string $lat1
     * @param float|string $lon1
     * @param float|string $lat2
     * @param float|string $lon2
     * @return float Distance in meters
     */
    public static function calculateDistance($lat1, $lon1, $lat2, $lon2): float
    {
        $lat1 = (float) $lat1;
        $lon1 = (float) $lon1;
        $lat2 = (float) $lat2;
        $lon2 = (float) $lon2;

        $earthRadius = 6371000;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
