@extends('layouts.dashboard')

@section('title', 'Pengaturan IP WiFi')

@section('content')
    {{-- Flash Messages --}}
    @if (session('success'))
        <div id="flash-success" class="mb-4 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            <svg class="w-5 h-5 shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div id="flash-error" class="mb-4 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <svg class="w-5 h-5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-orange-900">Pengaturan IP WiFi</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola daftar IP dan subnet kampus yang diizinkan mengakses sistem absensi.</p>
        </div>
        <div class="hidden lg:flex items-center gap-2 px-3 py-2 rounded-xl bg-white border border-gray-200 shadow-sm text-xs text-gray-600">
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            Cache diperbarui otomatis
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-6">
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total Entri</h3>
            <p class="text-3xl font-extrabold text-orange-900">{{ $allowedIps->count() }}</p>
            <p class="text-xs text-gray-500 mt-2">Semua IP & subnet terdaftar</p>
        </div>
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Aktif</h3>
            <p class="text-3xl font-extrabold text-emerald-600">{{ $allowedIps->where('is_active', true)->count() }}</p>
            <p class="text-xs text-gray-500 mt-2">Sedang digunakan untuk validasi</p>
        </div>
        <div class="bg-gradient-to-br from-orange-600 to-orange-800 rounded-2xl p-5 sm:p-6 shadow-sm text-white">
            <h3 class="text-xs font-semibold text-orange-200 uppercase tracking-wider mb-1">Nonaktif</h3>
            <p class="text-3xl font-extrabold">{{ $allowedIps->where('is_active', false)->count() }}</p>
            <p class="text-xs text-white/90 mt-2">Tidak terpakai saat validasi</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Form Tambah IP --}}
        <div class="xl:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 sm:px-6 py-5 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">Tambah IP Baru</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Dukung IPv4, IPv6, dan CIDR range.</p>
                </div>
                <form method="POST" action="{{ route('admin.allowed-ips.store') }}" class="p-5 sm:p-6 space-y-4">
                    @csrf
                    <div>
                        <label for="add-label" class="block text-xs font-semibold text-gray-700 mb-1.5">Label <span class="text-red-500">*</span></label>
                        <input
                            id="add-label"
                            type="text"
                            name="label"
                            value="{{ old('label') }}"
                            placeholder="Misal: WiFi Utama Gedung A"
                            class="w-full px-3.5 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all {{ $errors->has('label') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}"
                        >
                        @error('label')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="add-ip" class="block text-xs font-semibold text-gray-700 mb-1.5">IP / CIDR Range <span class="text-red-500">*</span></label>
                        <input
                            id="add-ip"
                            type="text"
                            name="ip_address"
                            value="{{ old('ip_address') }}"
                            placeholder="Misal: 103.113.118.0/23"
                            class="w-full px-3.5 py-2.5 text-sm border rounded-xl font-mono focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all {{ $errors->has('ip_address') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}"
                        >
                        @error('ip_address')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-400 mt-1.5">Format: <span class="font-mono">192.168.1.1</span>, <span class="font-mono">10.0.0.0/8</span>, atau <span class="font-mono">::1</span></p>
                    </div>
                    <div class="flex items-center gap-3 pt-1">
                        <button
                            type="button"
                            id="toggle-add-active"
                            onclick="toggleActiveBtn(this)"
                            data-active="1"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-1 bg-emerald-500"
                            role="switch"
                            aria-checked="true"
                        >
                            <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform translate-x-6"></span>
                        </button>
                        <input type="hidden" name="is_active" id="add-is-active" value="1">
                        <label class="text-sm font-medium text-gray-700">Aktifkan langsung</label>
                    </div>
                    <button
                        type="submit"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-orange-900 rounded-xl hover:bg-orange-800 transition-colors"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah IP
                    </button>
                </form>
            </div>

            {{-- Info Box --}}
            <div class="mt-4 bg-blue-50 border border-blue-100 rounded-2xl p-5">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="text-xs font-semibold text-blue-800 mb-1">Format yang Didukung</p>
                        <ul class="text-xs text-blue-700 space-y-1">
                            <li><span class="font-mono bg-blue-100 px-1 rounded">127.0.0.1</span> — IP tunggal IPv4</li>
                            <li><span class="font-mono bg-blue-100 px-1 rounded">::1</span> — IP tunggal IPv6</li>
                            <li><span class="font-mono bg-blue-100 px-1 rounded">103.113.118.0/23</span> — Subnet CIDR</li>
                        </ul>
                        <p class="text-xs text-blue-600 mt-2">Cache akan direset otomatis setiap ada perubahan.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Daftar IP --}}
        <div class="xl:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 sm:px-6 py-5 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">Daftar IP Terdaftar</h2>
                    <p class="text-sm text-gray-500 mt-0.5">IP dengan status aktif akan digunakan untuk validasi WiFi.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[560px]">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Label</th>
                                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">IP / CIDR</th>
                                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Ditambahkan</th>
                                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($allowedIps as $ip)
                                <tr class="hover:bg-gray-50 transition-colors {{ $ip->is_active ? '' : 'opacity-60' }}">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ $ip->is_active ? 'bg-emerald-50' : 'bg-gray-100' }}">
                                                <svg class="w-4 h-4 {{ $ip->is_active ? 'text-emerald-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                                                </svg>
                                            </div>
                                            <p class="text-sm font-semibold text-gray-800">{{ $ip->label }}</p>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="font-mono text-sm text-gray-700 bg-gray-100 px-2.5 py-1 rounded-lg">{{ $ip->ip_address }}</span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <form method="POST" action="{{ route('admin.allowed-ips.toggle', $ip) }}">
                                            @csrf
                                            <button type="submit" title="{{ $ip->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border transition-all hover:opacity-80 cursor-pointer
                                                    {{ $ip->is_active
                                                        ? 'bg-emerald-50 text-emerald-700 border-emerald-100'
                                                        : 'bg-gray-100 text-gray-500 border-gray-200' }}"
                                            >
                                                <span class="w-1.5 h-1.5 rounded-full {{ $ip->is_active ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                                {{ $ip->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-5 py-4 text-sm text-gray-500">
                                        {{ $ip->created_at?->format('d M Y') ?? '-' }}
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-2">
                                            <button
                                                type="button"
                                                onclick="openEditModal({{ $ip->id }}, '{{ addslashes($ip->label) }}', '{{ $ip->ip_address }}', {{ $ip->is_active ? 'true' : 'false' }})"
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-orange-700 bg-orange-50 border border-orange-100 rounded-lg hover:bg-orange-100 transition-colors"
                                            >
                                                Edit
                                            </button>
                                            <form method="POST" action="{{ route('admin.allowed-ips.destroy', $ip) }}" onsubmit="return confirm('Yakin ingin menghapus IP \"{{ addslashes($ip->label) }}\"?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-red-700 bg-red-50 border border-red-100 rounded-lg hover:bg-red-100 transition-colors">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-12 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-12 h-12 rounded-2xl bg-gray-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                                                </svg>
                                            </div>
                                            <p class="text-sm font-semibold text-gray-700">Belum ada IP terdaftar</p>
                                            <p class="text-xs text-gray-400">Tambahkan IP pertama menggunakan form di samping.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit IP --}}
    <div id="edit-modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-ink/60 backdrop-blur-sm transition-opacity" onclick="closeEditModal()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md mx-auto overflow-hidden transform transition-all">
            {{-- Decorative top accent --}}
            <div class="h-1 w-full bg-gradient-to-r from-orange-400 to-orange-600"></div>

            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Edit Entri IP</h3>
                        <p class="text-sm text-gray-500 mt-0.5">Perbarui informasi IP yang sudah terdaftar.</p>
                    </div>
                    <button type="button" onclick="closeEditModal()" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form id="edit-form" method="POST" action="" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="edit-label" class="block text-xs font-semibold text-gray-700 mb-1.5">Label <span class="text-red-500">*</span></label>
                        <input
                            id="edit-label"
                            type="text"
                            name="label"
                            placeholder="Misal: WiFi Utama Gedung A"
                            class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                            required
                        >
                    </div>
                    <div>
                        <label for="edit-ip" class="block text-xs font-semibold text-gray-700 mb-1.5">IP / CIDR Range <span class="text-red-500">*</span></label>
                        <input
                            id="edit-ip"
                            type="text"
                            name="ip_address"
                            placeholder="Misal: 103.113.118.0/23"
                            class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl font-mono focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                            required
                        >
                    </div>
                    <div class="flex items-center gap-3 pt-1">
                        <button
                            type="button"
                            id="toggle-edit-active"
                            onclick="toggleActiveBtn(this)"
                            data-active="1"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-1 bg-emerald-500"
                            role="switch"
                        >
                            <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform translate-x-6"></span>
                        </button>
                        <input type="hidden" name="is_active" id="edit-is-active" value="1">
                        <label class="text-sm font-medium text-gray-700" id="edit-active-label">Status: Aktif</label>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="closeEditModal()" class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-semibold rounded-xl transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2.5 bg-orange-900 hover:bg-orange-800 text-white text-sm font-semibold rounded-xl transition-colors">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // ── Toggle switch helper ──────────────────────────────────────────
    function toggleActiveBtn(btn) {
        const isActive = btn.dataset.active === '1';
        const newActive = !isActive;
        const dot = btn.querySelector('span');
        const hiddenInput = btn.id === 'toggle-add-active'
            ? document.getElementById('add-is-active')
            : document.getElementById('edit-is-active');
        const label = document.getElementById('edit-active-label');

        btn.dataset.active = newActive ? '1' : '0';
        hiddenInput.value = newActive ? '1' : '0';

        if (newActive) {
            btn.classList.remove('bg-gray-300');
            btn.classList.add('bg-emerald-500');
            dot.classList.remove('translate-x-1');
            dot.classList.add('translate-x-6');
            if (label) label.textContent = 'Status: Aktif';
        } else {
            btn.classList.remove('bg-emerald-500');
            btn.classList.add('bg-gray-300');
            dot.classList.remove('translate-x-6');
            dot.classList.add('translate-x-1');
            if (label) label.textContent = 'Status: Nonaktif';
        }
    }

    // ── Edit Modal ────────────────────────────────────────────────────
    function openEditModal(id, label, ip, isActive) {
        const modal = document.getElementById('edit-modal');
        const form  = document.getElementById('edit-form');
        const btn   = document.getElementById('toggle-edit-active');
        const dot   = btn.querySelector('span');
        const activeInput = document.getElementById('edit-is-active');
        const activeLabel = document.getElementById('edit-active-label');

        form.action = '/admin/allowed-ips/' + id;
        document.getElementById('edit-label').value = label;
        document.getElementById('edit-ip').value = ip;

        // Set toggle state
        btn.dataset.active = isActive ? '1' : '0';
        activeInput.value  = isActive ? '1' : '0';

        if (isActive) {
            btn.classList.add('bg-emerald-500');
            btn.classList.remove('bg-gray-300');
            dot.classList.add('translate-x-6');
            dot.classList.remove('translate-x-1');
            activeLabel.textContent = 'Status: Aktif';
        } else {
            btn.classList.remove('bg-emerald-500');
            btn.classList.add('bg-gray-300');
            dot.classList.remove('translate-x-6');
            dot.classList.add('translate-x-1');
            activeLabel.textContent = 'Status: Nonaktif';
        }

        modal.classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('edit-modal').classList.add('hidden');
    }

    // Close modal on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeEditModal();
    });

    // Auto-dismiss flash messages after 4 seconds
    ['flash-success', 'flash-error'].forEach(function(id) {
        const el = document.getElementById(id);
        if (el) {
            setTimeout(function () {
                el.style.transition = 'opacity 0.5s ease';
                el.style.opacity = '0';
                setTimeout(function () { el.remove(); }, 500);
            }, 4000);
        }
    });
</script>
@endpush
