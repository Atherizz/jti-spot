<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\IpUtils;
use App\Helpers\LocationHelper; // Sesuaikan dengan namespace aslimu

class CheckLocation
{
    public function handle(Request $request, Closure $next): Response
    {
        $clientIp = $request->ip();

        $rawAllowedIps = explode(',', env('ALLOWED_WIFI_IPS', '127.0.0.1'));
        $allowedIps = array_map('trim', $rawAllowedIps);

        $isIpValid = IpUtils::checkIp($clientIp, $allowedIps);

        $isGpsValid = false;
        $lat = $request->input('lat');
        $lng = $request->input('lng');

        if ($lat && $lng) {
            $jtiLat = env('JTI_LATITUDE', -7.946713);
            $jtiLng = env('JTI_LONGITUDE', 112.615668);
            $maxDistance = env('MAX_DISTANCE_METERS', 50);

            $distance = LocationHelper::calculateDistance($lat, $lng, $jtiLat, $jtiLng);

            if ($distance <= $maxDistance) {
                $isGpsValid = true;
            }
        }

        // 3. Keputusan Eksekusi: Harus memenuhi salah satu (WiFi ATAU GPS)
        if (!$isIpValid && !$isGpsValid) {
            return redirect()->route('student.dashboard.home')
                ->with('error', 'Akses ditolak. Anda berada di luar jangkauan gedung JTI atau tidak menggunakan WiFi kampus.');
        }

        return $next($request);
    }
}