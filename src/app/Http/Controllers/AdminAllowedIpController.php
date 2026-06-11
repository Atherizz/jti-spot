<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AllowedIp;
use App\Services\AllowedIpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AdminAllowedIpController extends Controller
{
    public function __construct(
        private readonly AllowedIpService $allowedIpService
    ) {}

    /**
     * Menampilkan daftar semua entri IP beserta form tambah.
     */
    public function index(): View
    {
        $allowedIps = AllowedIp::orderBy('is_active', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.allowed_ips.index', compact('allowedIps'));
    }

    /**
     * Menyimpan entri IP baru setelah validasi.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'label'      => ['required', 'string', 'max:100'],
            'ip_address' => ['required', 'string', 'max:50', function (string $attribute, mixed $value, \Closure $fail) {
                if (!$this->isValidIpOrCidr($value)) {
                    $fail('Format IP tidak valid. Gunakan IP tunggal (misal: 127.0.0.1) atau CIDR range (misal: 103.113.118.0/23).');
                }
            }],
            'is_active'  => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $this->allowedIpService->createEntry($validated);

        return redirect()->route('admin.allowed-ips.index')
            ->with('success', 'IP "' . $validated['label'] . '" berhasil ditambahkan.');
    }

    /**
     * Memperbarui entri IP yang sudah ada.
     */
    public function update(Request $request, AllowedIp $allowedIp): RedirectResponse
    {
        $validated = $request->validate([
            'label'      => ['required', 'string', 'max:100'],
            'ip_address' => ['required', 'string', 'max:50', function (string $attribute, mixed $value, \Closure $fail) {
                if (!$this->isValidIpOrCidr($value)) {
                    $fail('Format IP tidak valid. Gunakan IP tunggal (misal: 127.0.0.1) atau CIDR range (misal: 103.113.118.0/23).');
                }
            }],
            'is_active'  => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);

        $this->allowedIpService->updateEntry($allowedIp, $validated);

        return redirect()->route('admin.allowed-ips.index')
            ->with('success', 'IP "' . $validated['label'] . '" berhasil diperbarui.');
    }

    /**
     * Mengubah status aktif/nonaktif sebuah entri IP (toggle).
     */
    public function toggle(AllowedIp $allowedIp): RedirectResponse
    {
        $updated = $this->allowedIpService->toggleActive($allowedIp);

        $statusLabel = $updated->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.allowed-ips.index')
            ->with('success', 'IP "' . $updated->label . '" berhasil ' . $statusLabel . '.');
    }

    /**
     * Menghapus entri IP.
     */
    public function destroy(AllowedIp $allowedIp): RedirectResponse
    {
        $label = $allowedIp->label;
        $this->allowedIpService->deleteEntry($allowedIp);

        return redirect()->route('admin.allowed-ips.index')
            ->with('success', 'IP "' . $label . '" berhasil dihapus.');
    }

    /**
     * Memvalidasi apakah string adalah IP tunggal atau CIDR range yang valid.
     */
    private function isValidIpOrCidr(string $value): bool
    {
        // Cek apakah CIDR range (misal: 103.113.118.0/23)
        if (str_contains($value, '/')) {
            [$ip, $prefix] = explode('/', $value, 2);

            if (!is_numeric($prefix)) {
                return false;
            }

            $prefix = (int) $prefix;

            // IPv4 CIDR
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                return $prefix >= 0 && $prefix <= 32;
            }

            // IPv6 CIDR
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                return $prefix >= 0 && $prefix <= 128;
            }

            return false;
        }

        // Cek IP tunggal (IPv4 atau IPv6)
        return filter_var($value, FILTER_VALIDATE_IP) !== false;
    }
}
