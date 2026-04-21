@extends('layouts.dashboard')

@section('title', 'Detail Fasilitas')

@section('content')
    @php
        $roomLabel = $room->room_code ?? ('ROOM-' . $room->id);
        $buildingLabel = $room->floor ? ('Gedung LT ' . $room->floor) : 'Lantai Indefinit';
        $scanUrl = route('scan.initial', $room->qr_token);
        $qrImageUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&margin=10&data=' . urlencode($scanUrl);
    @endphp

    {{-- Editorial Breadcrumb & Header --}}
    <div class="mb-8 stagger-1">
        <div class="flex items-center gap-2 mb-3">
            <span class="font-display font-semibold uppercase tracking-widest text-[10px] text-ink/50 bg-gray-100 px-2 py-1 rounded">Manajemen Ruang</span>
            <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            <span class="font-display font-semibold uppercase tracking-widest text-[10px] text-ink/50">{{ $buildingLabel }}</span>
            <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            <span class="font-display font-bold uppercase tracking-widest text-[10px] text-orange-600">{{ $roomLabel }}</span>
        </div>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="font-display text-3xl sm:text-4xl font-bold tracking-tight text-ink leading-tight mb-2">
                    Operasional Ruang <span class="text-orange-600 border-b-2 border-orange-200">{{ $roomLabel }}</span>
                </h1>
                <p class="text-sm font-medium text-ink/60 max-w-xl leading-relaxed">
                    Instalasi kode QR statis untuk validasi geo-lokasi, parameter operasional, dan histori stempel akses.
                </p>
            </div>
            
            <button class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-xs font-bold text-ink bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors shadow-sm shrink-0">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Perbarui Metadata
            </button>
        </div>
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 stagger-2">
        
        {{-- QR Code Section (Left) --}}
        <section class="xl:col-span-4 flex flex-col h-full">
            <div class="editorial-panel bg-white p-6 sm:p-8 relative overflow-hidden flex flex-col items-center justify-center text-center h-full">
                <!-- Abstract glowing accent -->
                <div class="absolute inset-x-0 top-0 h-40 bg-gradient-to-b from-orange-50/50 to-transparent pointer-events-none"></div>

                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-orange-50 border border-orange-100 text-[10px] font-bold text-orange-700 uppercase tracking-widest mb-6 relative z-10">
                    <div class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></div>
                    Pemindai Ruangan Aktif
                </div>

                <div class="relative z-10 bg-white p-4 rounded-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] mb-6">
                    <img src="{{ $qrImageUrl }}" alt="QR Akses {{ $roomLabel }}" class="w-48 h-48 sm:w-56 sm:h-56 object-contain" />
                </div>

                <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-2 relative z-10">Tautan Integrasi Jaringan</p>
                <div class="w-full bg-gray-50 border border-gray-100 rounded-lg p-3 mb-6 relative z-10">
                    <p class="text-xs font-mono text-gray-500 truncate select-all">{{ $scanUrl }}</p>
                </div>

                <a href="{{ $scanUrl }}" target="_blank" rel="noopener noreferrer" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 text-sm font-bold text-white bg-ink rounded-xl hover:bg-ink/90 transition-colors shadow-sm relative z-10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Uji Tautan Eksternal
                </a>
            </div>
        </section>

        {{-- Log & Data Section (Right) --}}
        <section class="xl:col-span-8 flex flex-col gap-6">
            
            {{-- Mini Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="editorial-panel bg-white p-5 flex flex-col justify-between">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Rate Utilisasi</span>
                    <div class="flex items-end justify-between">
                        <span class="font-display text-3xl font-bold text-ink leading-none">75%</span>
                        <div class="flex items-center gap-1 text-emerald-500 bg-emerald-50 px-1.5 py-0.5 rounded text-[10px] font-bold">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                            5%
                        </div>
                    </div>
                </div>
                <div class="editorial-panel bg-white p-5 flex flex-col justify-between">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Pemindaian Hari Ini</span>
                    <div class="flex items-end justify-between">
                        <span class="font-display text-3xl font-bold text-ink leading-none">120</span>
                        <span class="text-[10px] font-bold text-gray-400">Entri</span>
                    </div>
                </div>
                <div class="editorial-panel bg-white p-5 flex flex-col justify-between">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Anomali Sistem</span>
                    <div class="flex items-end justify-between">
                        <span class="font-display text-3xl font-bold text-orange-600 leading-none">2</span>
                        <span class="text-[10px] font-bold text-orange-600/60 uppercase tracking-widest">Konflik</span>
                    </div>
                </div>
            </div>

            {{-- Live Audit Log --}}
            <div class="editorial-panel bg-white flex-1 overflow-hidden flex flex-col">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h2 class="font-display text-lg font-bold text-ink">Catatan Log Aktivitas</h2>
                        <p class="text-xs font-semibold text-gray-500 mt-1 uppercase tracking-widest">Data Audit Telemetri Ruang</p>
                    </div>
                    <button class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-500 flex items-center justify-center transition-colors shadow-sm" title="Refresh Telemetri">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582M20 20v-5h-.581M5 9a7 7 0 0112.48-3.856L20 9M4 15l2.52 3.856A7 7 0 0019 15" />
                        </svg>
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100 text-left">
                                <th class="px-6 py-4 font-display text-[10px] font-bold text-ink/50 uppercase tracking-widest">Nama</th>
                                <th class="px-6 py-4 font-display text-[10px] font-bold text-ink/50 uppercase tracking-widest">Waktu Scan</th>
                                <th class="px-6 py-4 font-display text-[10px] font-bold text-ink/50 uppercase tracking-widest">Status Validasi</th>
                                <th class="px-6 py-4 font-display text-[10px] font-bold text-ink/50 uppercase tracking-widest text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recentLogs as $log)
                                <tr class="hover:bg-gray-50/50 transition-colors {{ $log->event_type === 'SCAN_FAILED' ? 'bg-rose-50/20' : '' }}">
                                    <td class="px-6 py-4">
                                        <p class="font-bold {{ $log->event_type === 'SCAN_FAILED' ? 'text-rose-900' : 'text-ink' }} text-sm">{{ $log->user->name ?? 'Entitas Anonim' }}</p>
                                        <p class="text-[10px] font-mono {{ $log->event_type === 'SCAN_FAILED' ? 'text-rose-400' : 'text-gray-400' }} mt-0.5">{{ $log->user->reg_number ?? 'Tidak Dikenali' }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-ink text-sm">{{ $log->created_at->format('h:i A') }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold {{ $log->event_type === 'SCAN_SUCCESS' ? 'bg-blue-50 text-blue-600 border border-blue-100' : 'bg-gray-100 text-gray-500 border border-gray-200' }} uppercase tracking-widest">
                                            {{ $log->event_type === 'SCAN_SUCCESS' ? 'Sistem QR' : 'Gagal Validasi' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="inline-flex items-center gap-1.5 {{ $log->event_type === 'SCAN_SUCCESS' ? 'text-emerald-600' : 'text-rose-600' }} font-bold text-xs uppercase tracking-widest">
                                            <div class="w-1.5 h-1.5 rounded-full {{ $log->event_type === 'SCAN_SUCCESS' ? 'bg-emerald-500' : 'bg-rose-500' }}"></div>
                                            {{ $log->event_type === 'SCAN_SUCCESS' ? 'Sukses' : 'Ditolak' }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500 font-medium">Belum ada data log aktivitas untuk ruangan ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="p-4 border-t border-gray-100 bg-gray-50/30 text-center">
                    <a href="#" class="text-xs font-bold text-orange-600 uppercase tracking-widest hover:text-orange-800 transition-colors">Tarik Lebih Banyak Data Audit</a>
                </div>
            </div>
            
        </section>
    </div>
@endsection

