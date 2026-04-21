@extends('layouts.dashboard')

@section('title', 'Pusat Manajemen Data')

@section('content')

    @php
        $roomLoadPercent = $totalRooms > 0 ? (int) round((($roomStats['occupied'] ?? 0) / $totalRooms) * 100) : 0;
        $standbyRooms = (int) ($roomStats['available'] ?? 0);
        $occupiedRooms = (int) ($roomStats['occupied'] ?? 0);
        $waitingWithoutConflictRooms = (int) ($waitingWithoutConflictCount ?? 0);
    @endphp

    {{-- Editorial Formal Hero --}}
    <div class="editorial-panel bg-white mb-8 stagger-1 flex flex-col md:flex-row overflow-hidden relative">
        <!-- Abstract geometric decoration (softer) -->
        <div class="absolute right-0 top-0 w-96 h-96 bg-orange-50 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3 pointer-events-none"></div>

        <div class="flex-1 p-8 md:p-10 border-b md:border-b-0 md:border-r border-ink/5 relative z-10 w-full">
            <div class="flex items-center gap-2 mb-4">
                <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-[11px] font-bold uppercase tracking-widest text-emerald-600">Sistem Normal &bull; Auto-Sync Aktif</span>
            </div>
            
            <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight leading-tight mb-4 text-ink">
                Pusat Manajemen Data
            </h1>
            
            <p class="text-base max-w-xl text-ink/60">
                Selamat datang kembali, <span class="font-semibold text-ink">{{ auth()->user()->name }}</span>. 
                Sistem ini memungkinkan Anda memantau seluruh armada ruang kelas dan pergerakan jadwal kampus secara terpusat.
            </p>

            <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-ink/40 mt-5">{{ $todayLabel }}</p>
        </div>

        <div class="w-full md:w-72 flex flex-col relative z-10">
            <div class="flex-1 p-8 border-b border-ink/5 bg-gray-50/50 backdrop-blur-sm relative group overflow-hidden">
                <div class="relative z-10">
                        <p class="text-[11px] font-semibold uppercase tracking-widest text-ink/40 mb-1">Kepadatan Ruang Hari Ini</p>
                    <div class="flex items-end gap-1">
                            <p class="font-display text-4xl font-bold text-ink">{{ $roomLoadPercent }}</p>
                        <p class="text-xl font-medium text-ink/40 pb-1">%</p>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 bg-emerald-50/50 relative overflow-hidden group border-b md:border-b-0 border-ink/5">
                <div class="relative z-10">
                        <p class="text-[11px] font-semibold uppercase tracking-widest text-emerald-700 mb-1">Ruang Tersedia Sekarang</p>
                    <div class="flex items-end gap-1">
                            <p class="font-display text-4xl font-bold text-emerald-700">{{ $standbyRooms }}</p>
                        <p class="text-sm font-medium text-emerald-700/60 pb-1 mb-0.5">ruang</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Formal Statistics Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 stagger-2">
        
        <div class="editorial-panel bg-white p-6 relative group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-xl bg-ink/5 flex items-center justify-center text-ink/60">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-gray-100 text-gray-600">
                    {{ $totalRooms }} Total
                </span>
            </div>
            <p class="text-sm font-medium text-ink/50 mb-1">Total Ruang Kelas</p>
            <p class="font-display text-3xl font-bold text-ink">{{ $totalRooms }}</p>
        </div>

        <div class="editorial-panel bg-white p-6 relative group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-orange-50 text-orange-600 border border-orange-100">
                    Hari Ini
                </span>
            </div>
            <p class="text-sm font-medium text-ink/50 mb-1">Jadwal Aktif Saat Ini</p>
            <p class="font-display text-3xl font-bold text-ink">{{ $activeSchedulesNow->count() }}</p>
        </div>

        <div class="editorial-panel bg-white p-6 relative group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-orange-100 text-orange-700">
                    Aktif
                </span>
            </div>
            <p class="text-sm font-medium text-ink/50 mb-1">Klaim/Konflik Aktif</p>
            <p class="font-display text-3xl font-bold text-orange-600">{{ $claimConflictCount }}</p>
        </div>

        <a href="{{ route('admin.schedules') }}" class="editorial-panel bg-ink text-white p-6 flex flex-col justify-center items-center text-center hover:bg-ink/90 transition-colors group">
            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            </div>
            <h3 class="font-display text-lg font-bold tracking-tight">Entri Jadwal Baru</h3>
            <p class="text-xs text-white/50 mt-1">Kelola dan tambahkan sesi baru</p>
        </a>

    </div>

    {{-- Modern Formal Table --}}
    <div class="editorial-panel overflow-hidden stagger-3 mb-12">
        
        {{-- Table Header Banner --}}
        <div class="p-6 md:p-8 bg-white border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h2 class="font-display text-xl font-bold tracking-tight text-ink mb-1">Matrix Pengendalian Aset</h2>
                <p class="text-sm text-gray-500">Ketersediaan ruang aktual dan penyelesaian anomali penjadwalan.</p>
            </div>
            <form method="GET" action="{{ route('admin.dashboard.home') }}" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <div class="relative flex-1 md:w-64">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    <input type="text" name="q" value="{{ $searchQuery ?? '' }}" placeholder="Cari data ruang..." class="w-full pl-9 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-ink/10 focus:bg-white transition-colors">
                </div>
                <button type="submit" name="status" value="all" class="px-4 py-2.5 text-sm font-medium text-ink bg-white border rounded-xl hover:bg-white hover:text-ink hover:border-gray-300 transition-colors flex items-center gap-2 {{ ($selectedStatus ?? 'all') === 'all' ? 'border-ink shadow-md' : 'border-gray-200 shadow-sm' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18l-7 9v8l-4-3v-5L3 4z" /></svg>
                    Semua Status
                </button>
                <button type="submit" name="status" value="available" class="px-4 py-2.5 text-sm font-medium text-ink bg-white border rounded-xl hover:bg-white hover:text-ink hover:border-gray-300 transition-colors {{ ($selectedStatus ?? 'all') === 'available' ? 'border-ink shadow-md' : 'border-gray-200 shadow-sm' }}">Tersedia</button>
                <button type="submit" name="status" value="occupied" class="px-4 py-2.5 text-sm font-medium text-ink bg-white border rounded-xl hover:bg-white hover:text-ink hover:border-gray-300 transition-colors {{ ($selectedStatus ?? 'all') === 'occupied' ? 'border-ink shadow-md' : 'border-gray-200 shadow-sm' }}">Terpakai</button>
                <button type="submit" name="status" value="waiting" class="px-4 py-2.5 text-sm font-medium text-ink bg-white border rounded-xl hover:bg-white hover:text-ink hover:border-gray-300 transition-colors {{ ($selectedStatus ?? 'all') === 'waiting' ? 'border-ink shadow-md' : 'border-gray-200 shadow-sm' }}">Konflik</button>
                <button type="submit" name="status" value="waiting_confirmation" class="px-4 py-2.5 text-sm font-medium text-ink bg-white border rounded-xl hover:bg-white hover:text-ink hover:border-gray-300 transition-colors {{ ($selectedStatus ?? 'all') === 'waiting_confirmation' ? 'border-ink shadow-md' : 'border-gray-200 shadow-sm' }}">Menunggu</button>
            </form>
        </div>

        {{-- Table Data --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        <th class="px-6 py-4 font-display text-xs font-semibold text-gray-500 tracking-wider">Identifikasi</th>
                        <th class="px-6 py-4 font-display text-xs font-semibold text-gray-500 tracking-wider">Mata Kuliah / Kelompok</th>
                        <th class="px-6 py-4 font-display text-xs font-semibold text-gray-500 tracking-wider">Durasi Waktu</th>
                        <th class="px-6 py-4 font-display text-xs font-semibold text-gray-500 tracking-wider">Sistem Status</th>
                        <th class="px-6 py-4 font-display text-xs font-semibold text-gray-500 tracking-wider">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse ($dashboardRows as $row)
                        <tr
                            class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors cursor-pointer {{ $row['status_tone'] === 'orange' ? 'bg-orange-50/30 hover:bg-orange-50/60' : '' }} {{ $row['status_tone'] === 'amber' ? 'bg-amber-50/30 hover:bg-amber-50/60' : '' }}"
                            data-room-row
                            data-status="{{ $row['status_filter'] }}"
                            data-search="{{ strtolower(trim($row['code'] . ' ' . $row['name'] . ' ' . $row['location'] . ' ' . $row['status_label'] . ' ' . ($row['course_name'] ?? '') . ' ' . ($row['class_group'] ?? ''))) }}"
                            data-room-payload='@json($row)'
                        >
                            <td class="px-6 py-4">
                                <div class="font-semibold {{ $row['status_tone'] === 'orange' ? 'text-orange-900' : ($row['status_tone'] === 'amber' ? 'text-amber-900' : 'text-ink') }}">{{ $row['code'] }}</div>
                                <div class="text-xs {{ $row['status_tone'] === 'orange' ? 'text-orange-600/70' : ($row['status_tone'] === 'amber' ? 'text-amber-700/70' : 'text-gray-500') }} mt-0.5">{{ $row['location'] }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-ink">{{ $row['course_name'] ?? 'Belum ada jadwal' }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">{{ $row['class_group'] ?? 'Kelas belum ditentukan' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-gray-50 border border-gray-100 text-xs font-medium text-gray-600">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    {{ $row['time_range'] }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $row['status_tone'] === 'emerald' ? 'bg-emerald-50 border border-emerald-100 text-emerald-700' : ($row['status_tone'] === 'orange' ? 'bg-orange-100 border border-orange-200 text-orange-800' : ($row['status_tone'] === 'amber' ? 'bg-amber-100 border border-amber-200 text-amber-800' : 'bg-slate-100 text-slate-700')) }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $row['status_tone'] === 'emerald' ? 'bg-emerald-500' : ($row['status_tone'] === 'orange' ? 'bg-orange-500 animate-pulse' : ($row['status_tone'] === 'amber' ? 'bg-amber-500' : 'bg-slate-500')) }}"></span>
                                    {{ $row['status_label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <button type="button" class="px-3 py-1.5 text-xs font-medium bg-white border border-gray-200 rounded-lg hover:border-gray-300 hover:bg-gray-50 text-ink transition-all shadow-sm" data-open-room-detail>
                                    {{ $row['status_tone'] === 'orange' ? 'Tinjau' : ($row['status_tone'] === 'amber' ? 'Konfirmasi' : 'Detail') }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500">Belum ada data ruang yang bisa ditampilkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Table Footer --}}
        <div class="px-6 py-4 border-t border-gray-100 bg-white flex flex-col gap-4 sm:flex-row sm:justify-between sm:items-center text-sm">
            <span class="text-gray-500">
                Menampilkan {{ $dashboardRows->firstItem() ?? 0 }} - {{ $dashboardRows->lastItem() ?? 0 }} dari {{ $dashboardRows->total() }} ruang
            </span>

            <div class="dashboard-pagination [&_nav]:m-0 [&_nav]:bg-transparent [&_nav]:shadow-none [&_nav]:border-0 [&_a]:text-ink [&_button]:text-ink [&_a:hover]:bg-gray-50 [&_button:hover]:bg-gray-50">
                {{ $dashboardRows->links() }}
            </div>
        </div>

    </div>

    @if ($recentActivities->isNotEmpty())
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-12 stagger-4">
            <div class="xl:col-span-2 editorial-panel bg-white p-6">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="font-display text-lg font-bold text-ink">Aktivitas Terbaru</h3>
                        <p class="text-sm text-gray-500">Jejak aktivitas ruang, jadwal, dan sinkronisasi terbaru.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach ($recentActivities as $activity)
                        <div class="flex items-start gap-4 rounded-xl border border-gray-100 p-4 hover:bg-gray-50/70 transition-colors">
                            <div class="w-10 h-10 rounded-xl bg-ink/5 flex items-center justify-center text-ink/60 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <p class="font-semibold text-ink">{{ $activity->event_type }}</p>
                                    <span class="text-xs text-gray-400">{{ $activity->created_at?->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-600">
                                    {{ $activity->user?->name ?? 'Sistem' }}
                                    @if ($activity->room)
                                        di {{ $activity->room->name }}
                                    @endif
                                    @if ($activity->schedule)
                                        untuk {{ $activity->schedule->course_name }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="editorial-panel bg-white p-6">
                <h3 class="font-display text-lg font-bold text-ink mb-1">Ringkasan Cepat</h3>
                <p class="text-sm text-gray-500 mb-5">Statistik yang paling sering dipakai admin.</p>

                <div class="space-y-4">
                    <div class="rounded-xl bg-emerald-50 border border-emerald-100 p-4">
                        <p class="text-xs font-semibold uppercase tracking-widest text-emerald-600 mb-1">Ruang Tersedia</p>
                        <p class="font-display text-3xl font-bold text-emerald-700">{{ $standbyRooms }}</p>
                    </div>
                    <div class="rounded-xl bg-slate-50 border border-slate-100 p-4">
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-500 mb-1">Ruang Terpakai</p>
                        <p class="font-display text-3xl font-bold text-slate-700">{{ $occupiedRooms }}</p>
                    </div>
                    <div class="rounded-xl bg-orange-50 border border-orange-100 p-4">
                        <p class="text-xs font-semibold uppercase tracking-widest text-orange-600 mb-1">Klaim/Konflik</p>
                        <p class="font-display text-3xl font-bold text-orange-700">{{ $claimConflictCount }}</p>
                    </div>
                    <div class="rounded-xl bg-amber-50 border border-amber-100 p-4">
                        <p class="text-xs font-semibold uppercase tracking-widest text-amber-600 mb-1">Menunggu Konfirmasi</p>
                        <p class="font-display text-3xl font-bold text-amber-700">{{ $waitingWithoutConflictRooms }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div data-room-modal class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
        <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl overflow-hidden">
            <div class="flex items-start justify-between border-b border-gray-100 px-6 py-5">
                <div>
                    <h3 class="font-display text-lg font-bold text-ink" data-modal-title>Detail Ruang</h3>
                    <p class="text-sm text-gray-500">Informasi ruang dan status jadwal terbaru.</p>
                </div>
                <button type="button" class="rounded-lg p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600" data-room-modal-close>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="px-6 py-6" data-room-modal-body></div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const rows = Array.from(document.querySelectorAll('[data-room-row]'));
                const modal = document.querySelector('[data-room-modal]');
                const modalTitle = document.querySelector('[data-modal-title]');
                const modalBody = document.querySelector('[data-room-modal-body]');
                const modalCloseButtons = Array.from(document.querySelectorAll('[data-room-modal-close]'));

                const closeModal = () => {
                    if (!modal) {
                        return;
                    }

                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    document.body.classList.remove('overflow-hidden');
                };

                const openModal = (payload) => {
                    if (!modal || !modalBody || !modalTitle) {
                        return;
                    }

                    modalTitle.textContent = `${payload.code} - ${payload.name}`;
                    modalBody.innerHTML = `
                        <div class="space-y-5">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-1">Lokasi</p>
                                <p class="text-sm font-medium text-ink">${payload.location ?? '-'}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-1">Mata Kuliah</p>
                                    <p class="text-sm font-medium text-ink">${payload.course_name ?? 'Belum ada jadwal'}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-1">Kelompok</p>
                                    <p class="text-sm font-medium text-ink">${payload.class_group ?? 'Belum ditentukan'}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-1">Durasi</p>
                                    <p class="text-sm font-medium text-ink">${payload.time_range ?? '-'}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-1">Status</p>
                                    <p class="text-sm font-medium text-ink">${payload.status_label ?? '-'}</p>
                                </div>
                            </div>
                            <div class="flex gap-3 pt-2">
                                <a href="${payload.detail_url}" class="flex-1 rounded-xl bg-ink px-4 py-3 text-center text-sm font-semibold text-white hover:bg-ink/90 transition-colors">Buka Detail Ruang</a>
                                <a href="${payload.schedule_url}" class="flex-1 rounded-xl border border-gray-200 px-4 py-3 text-center text-sm font-semibold text-ink hover:bg-gray-50 transition-colors">Lihat Jadwal</a>
                            </div>
                        </div>
                    `;

                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    document.body.classList.add('overflow-hidden');
                };

                rows.forEach((row) => {
                    row.addEventListener('click', () => {
                        const payload = JSON.parse(row.dataset.roomPayload ?? '{}');
                        openModal(payload);
                    });
                });

                Array.from(document.querySelectorAll('[data-open-room-detail]')).forEach((button) => {
                    button.addEventListener('click', (event) => {
                        event.stopPropagation();
                        const row = button.closest('[data-room-row]');

                        if (!row) {
                            return;
                        }

                        const payload = JSON.parse(row.dataset.roomPayload ?? '{}');
                        openModal(payload);
                    });
                });

                modalCloseButtons.forEach((button) => {
                    button.addEventListener('click', closeModal);
                });

                modal?.addEventListener('click', (event) => {
                    if (event.target === modal) {
                        closeModal();
                    }
                });

                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape') {
                        closeModal();
                    }
                });
            });
        </script>
    @endpush

@endsection

