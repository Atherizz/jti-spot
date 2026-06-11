<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AllowedIp;
use Illuminate\Support\Facades\Cache;

class AllowedIpService
{
    private const CACHE_KEY = 'allowed_ips_active_list';
    private const CACHE_TTL_SECONDS = 300; // 5 menit

    /**
     * Mengambil daftar IP aktif dari cache atau database.
     * Fallback ke loopback jika tabel kosong agar sistem tidak langsung memblokir semua.
     *
     * @return array<string>
     */
    public function getActiveIpList(): array
    {
        $ipList = Cache::remember(
            self::CACHE_KEY,
            self::CACHE_TTL_SECONDS,
            fn () => AllowedIp::active()->pluck('ip_address')->all()
        );

        if (empty($ipList)) {
            return ['127.0.0.1', '::1'];
        }

        return $ipList;
    }

    /**
     * Membersihkan cache IP aktif. Harus dipanggil setiap kali ada perubahan data.
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Membuat entri IP baru.
     */
    public function createEntry(array $data): AllowedIp
    {
        $allowedIp = AllowedIp::create([
            'label'      => $data['label'],
            'ip_address' => $data['ip_address'],
            'is_active'  => $data['is_active'] ?? true,
        ]);

        $this->clearCache();

        return $allowedIp;
    }

    /**
     * Memperbarui entri IP yang sudah ada.
     */
    public function updateEntry(AllowedIp $allowedIp, array $data): AllowedIp
    {
        $allowedIp->update([
            'label'      => $data['label'],
            'ip_address' => $data['ip_address'],
            'is_active'  => $data['is_active'] ?? $allowedIp->is_active,
        ]);

        $this->clearCache();

        return $allowedIp->fresh();
    }

    /**
     * Mengubah status aktif/nonaktif sebuah entri IP.
     */
    public function toggleActive(AllowedIp $allowedIp): AllowedIp
    {
        $allowedIp->update(['is_active' => !$allowedIp->is_active]);

        $this->clearCache();

        return $allowedIp->fresh();
    }

    /**
     * Menghapus entri IP.
     */
    public function deleteEntry(AllowedIp $allowedIp): void
    {
        $allowedIp->delete();

        $this->clearCache();
    }
}
