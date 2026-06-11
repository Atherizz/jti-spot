<?php

namespace App\Http\Middleware;

use App\Services\AllowedIpService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\IpUtils;
use App\Helpers\LocationHelper;

class CheckLocation
{
    public function __construct(
        private readonly AllowedIpService $allowedIpService
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        // Resolve real client IP dengan prioritas:
        // 1. CF-Connecting-IP  → paling reliable jika pakai Cloudflare
        // 2. X-Forwarded-For pertama → real IP sebelum melewati proxy chain
        // 3. $request->ip()    → fallback bawaan Laravel
        $cfConnectingIp     = $request->header('CF-Connecting-IP');
        $xForwardedForFirst = $request->header('X-Forwarded-For')
            ? trim(explode(',', $request->header('X-Forwarded-For'))[0])
            : null;

        $clientIp = $cfConnectingIp ?? $xForwardedForFirst ?? $request->ip();

        // Ambil daftar IP yang diizinkan dari database (via cache 5 menit)
        $allowedIps = $this->allowedIpService->getActiveIpList();

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

        // Keputusan Eksekusi: Harus memenuhi salah satu (WiFi ATAU GPS)
        if (!$isIpValid && !$isGpsValid) {
            return redirect()->route('student.dashboard.home')
                ->with('error', 'Akses ditolak. Anda berada di luar jangkauan gedung JTI atau tidak menggunakan WiFi kampus.');
        }

        return $next($request);
    }
}