@extends('layouts.dashboard')

@section('title', 'Manajemen Ruang')

@section('content')
    @php
        $statusClass = function (string $status): string {
            return match ($status) {
                'available' => 'bg-emerald-50 text-emerald-700 border border-emerald-100',
                'occupied' => 'bg-rose-50 text-rose-700 border border-rose-100',
                'waiting' => 'bg-amber-50 text-amber-700 border border-amber-100',
                default => 'bg-gray-100 text-gray-700 border border-gray-200',
            };
        };

        $dotClass = function (string $status): string {
            return match ($status) {
                'available' => 'bg-emerald-500',
                'occupied' => 'bg-rose-500',
                'waiting' => 'bg-amber-500',
                default => 'bg-gray-500',
            };
        };

        $statusLabel = function (string $status): string {
            return match ($status) {
                'available' => 'Tersedia',
                'occupied' => 'Terpakai',
                'waiting' => 'Menunggu',
                default => ucwords(str_replace('_', ' ', $status)),
            };
        };
    @endphp

    @if (session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800 flex items-center gap-2">
            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->has('excel_file'))
        <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800 flex items-center gap-2">
            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            {{ $errors->first('excel_file') }}
        </div>
    @endif

    {{-- Editorial Page Header --}}
    <div class="mb-10 stagger-1 bg-white editorial-panel p-8 flex flex-col md:flex-row items-start md:items-center justify-between relative overflow-hidden group">
        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-orange-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
        <div class="relative z-10 w-full">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></div>
                <span class="font-display font-semibold uppercase tracking-widest text-[11px] text-ink/50">Direktori Fasilitas</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6">
                <div>
                    <h1 class="font-display text-3xl sm:text-4xl font-bold tracking-tight text-ink leading-tight">Manajemen Ruang</h1>
                    <p class="text-sm font-medium text-ink/60 mt-2 max-w-xl">
                        Kelola seluruh data ruangan kelas, verifikasi fasilitas, dan pantau status ketersediaan secara sentralistik.
                    </p>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <a href="{{ route('admin.rooms.qr.print.all') }}" target="_blank"
                       class="inline-flex items-center justify-center gap-2 px-5 py-3 text-xs sm:text-sm font-bold text-ink bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                        <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2M6 14h12v8H6v-8z"/>
                        </svg>
                        Print Semua QR
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Formal Statistics Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8 stagger-2">
        <div class="editorial-panel bg-white p-6 relative group transform hover:-translate-y-1 transition-transform">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-xl bg-ink/5 flex items-center justify-center text-ink/60 border border-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-500 tracking-widest uppercase">Total Aset</span>
            </div>
            <p class="font-display text-3xl font-bold text-ink">{{ $stats['total'] }}</p>
        </div>

        <div class="editorial-panel bg-white p-6 relative group transform hover:-translate-y-1 transition-transform">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 border border-blue-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 4h14a2 2 0 012 2v7H3V6a2 2 0 012-2z" /></svg>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-500 tracking-widest uppercase">Tipe Lab</span>
            </div>
            <p class="font-display text-3xl font-bold text-ink">{{ $stats['lab'] }}</p>
        </div>

        <div class="editorial-panel bg-white p-6 relative group transform hover:-translate-y-1 transition-transform">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 border border-emerald-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16h6M4 6h16v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" /></svg>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-500 tracking-widest uppercase">Teori</span>
            </div>
            <p class="font-display text-3xl font-bold text-ink">{{ $stats['theory'] }}</p>
        </div>

        <div class="editorial-panel bg-white p-6 relative group transform hover:-translate-y-1 transition-transform">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600 border border-orange-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-500 tracking-widest uppercase">Menunggu</span>
            </div>
            <p class="font-display text-3xl font-bold text-ink">{{ $stats['waiting'] }}</p>
        </div>
    </div>

    {{-- Formal Rooms Table --}}
    <div class="editorial-panel bg-white overflow-hidden stagger-3">

        <div class="p-6 md:p-8 border-b border-gray-100 bg-gray-50/30">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                <div>
                    <h2 class="font-display text-xl font-bold text-ink">Indeks Ruangan</h2>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-3">
                    <form method="GET" action="{{ route('admin.room.room') }}" class="flex items-center gap-3 w-full sm:w-auto">
                        <div class="relative w-full sm:w-64">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />
                            </svg>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari Kode/Nama Ruang..."
                                class="w-full pl-10 pr-4 py-2.5 text-sm font-medium bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-100 outline-none transition placeholder:text-gray-400" />
                        </div>
                        <button type="submit" class="inline-flex items-center justify-center w-11 h-11 rounded-xl bg-ink text-white hover:bg-ink/90 transition-colors shadow-sm shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-100 text-left">
                        <th class="px-6 py-4 font-display text-[11px] font-bold text-ink/50 uppercase tracking-widest">Identifikasi (Kode)</th>
                        <th class="px-6 py-4 font-display text-[11px] font-bold text-ink/50 uppercase tracking-widest">Lokasi Lantai</th>
                        <th class="px-6 py-4 font-display text-[11px] font-bold text-ink/50 uppercase tracking-widest">Sistem Status</th>
                        <th class="px-6 py-4 font-display text-[11px] font-bold text-ink/50 uppercase tracking-widest text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($rooms as $room)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-bold text-ink text-sm">{{ $room->room_code ?? ('ROOM-' . $room->id) }}</span>
                                <div class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest mt-0.5">{{ $room->room_type }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-gray-600">{{ $room->floor ? 'Lantai ' . $room->floor : '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded text-[10px] font-bold tracking-widest uppercase {{ $statusClass($room->current_status) }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $dotClass($room->current_status) }}"></span>
                                    {{ $statusLabel($room->current_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.room.detail', ['roomCode' => $room->room_code ?? $room->id]) }}" class="inline-flex items-center justify-center gap-2 px-3 py-1.5 text-xs font-bold text-ink bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                                    Detail
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center">
                                <div class="text-gray-400 mb-2">
                                    <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                </div>
                                <p class="text-sm font-medium text-ink/50">Direktori ruangan kosong.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30 flex items-center justify-between">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-widest">
                Tampilan {{ $rooms->count() }} Entri
            </span>
            <div class="flex items-center gap-2">
                {{ $rooms->links() }}
            </div>
        </div>
    </div>

@endsection
