<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\LocationHelper;

class CheckLocation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Ekstrak IP Asli (Kebal Proxy/Ngrok)
        $rawIp = $request->header('x-forwarded-for') ?: $request->ip();
        $clientIp = trim(explode(',', $rawIp)[0]);

        // Ambil daftar IP yang diizinkan dari .env
        $allowedIps = explode(',', env('ALLOWED_WIFI_IPS', '127.0.0.1'));

        // Cek Validitas IP
        $isIpValid = in_array($clientIp, $allowedIps);

        // 2. Cek Jarak GPS (Jika request mengirimkan lat & lng)
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

        if (!$isIpValid && !$isGpsValid) {
            return redirect()->route('student.dashboard.home')
                ->with('error', 'Akses ditolak. Anda berada di luar jangkauan gedung JTI atau tidak menggunakan WiFi kampus.');
        }

        return $next($request);
    }
}
