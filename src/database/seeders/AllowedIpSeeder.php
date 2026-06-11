<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\AllowedIp;
use Illuminate\Database\Seeder;

class AllowedIpSeeder extends Seeder
{
    /**
     * Meng-seed data awal IP dari konfigurasi lama di .env:
     * ALLOWED_WIFI_IPS="103.113.118.0/23,103.182.234.0/24,127.0.0.1,::1"
     */
    public function run(): void
    {
        $entries = [
            [
                'label'      => 'WiFi Kampus JTI - Blok A (103.113.118.0/23)',
                'ip_address' => '103.113.118.0/23',
                'is_active'  => true,
            ],
            [
                'label'      => 'WiFi Kampus JTI - Blok B (103.182.234.0/24)',
                'ip_address' => '103.182.234.0/24',
                'is_active'  => true,
            ],
            [
                'label'      => 'Localhost IPv4 (Development)',
                'ip_address' => '127.0.0.1',
                'is_active'  => true,
            ],
            [
                'label'      => 'Localhost IPv6 (Development)',
                'ip_address' => '::1',
                'is_active'  => true,
            ],
        ];

        foreach ($entries as $entry) {
            // Hindari duplikasi jika seeder dijalankan berulang kali
            AllowedIp::firstOrCreate(
                ['ip_address' => $entry['ip_address']],
                $entry
            );
        }
    }
}
