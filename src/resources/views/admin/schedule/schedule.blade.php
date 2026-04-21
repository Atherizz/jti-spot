@extends('layouts.dashboard')

@section('title', 'Semua Jadwal')

@section('content')

    @if (session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-bold text-emerald-800 flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm font-bold text-rose-800 flex items-center gap-3">
            <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->has('excel_file'))
        <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm font-bold text-rose-800 flex items-center gap-3">
            <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            {{ $errors->first('excel_file') }}
        </div>
    @endif

    {{-- Editorial Page Header --}}
    <div class="mb-10 stagger-1 bg-white editorial-panel p-8 relative overflow-hidden group">
        <div class="absolute -right-32 -top-32 w-80 h-80 bg-orange-50 rounded-full blur-3xl opacity-60 pointer-events-none"></div>
        <div class="relative z-10">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></div>
                <span class="font-display font-semibold uppercase tracking-widest text-[11px] text-ink/50">Kurikulum Global</span>
            </div>
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <h1 class="font-display text-3xl sm:text-4xl font-bold tracking-tight text-ink leading-tight mb-2">Pusat Jadwal Akademik</h1>
                    <p class="text-sm font-medium text-ink/60 max-w-xl leading-relaxed">
                        Kelola agregasi jadwal kelas seluruh program studi, konfirmasi slot ketersediaan ruang, dan pembaruan masal (*batch update*) via konfigurasi Excel.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Formal Statistics Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8 stagger-2">
        <div class="editorial-panel bg-white p-6 relative group transform hover:-translate-y-1 transition-transform">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-xl bg-ink/5 flex items-center justify-center text-ink/60 border border-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-500 tracking-widest uppercase">Akumulasi Jadwal</span>
            </div>
            <p class="font-display text-3xl font-bold text-ink">{{ $stats['total'] }}</p>
        </div>

        <div class="editorial-panel bg-white p-6 relative group transform hover:-translate-y-1 transition-transform border-b-2 sm:border-b-0 border-orange-500">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600 border border-orange-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-orange-50 text-orange-700 tracking-widest uppercase border border-orange-100">Agenda Hari Ini</span>
            </div>
            <p class="font-display text-3xl font-bold text-ink">{{ $stats['today'] }}</p>
        </div>

        <div class="editorial-panel bg-white p-6 relative group transform hover:-translate-y-1 transition-transform">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 border border-emerald-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-500 tracking-widest uppercase">Ruang Dialokasikan</span>
            </div>
            <p class="font-display text-3xl font-bold text-ink">{{ $stats['rooms'] }}</p>
        </div>

        <div class="editorial-panel bg-white p-6 relative group transform hover:-translate-y-1 transition-transform">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600 border border-orange-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857" /></svg>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-500 tracking-widest uppercase">Kelas Aktif</span>
            </div>
            <p class="font-display text-3xl font-bold text-ink">{{ $stats['classes'] }}</p>
        </div>
    </div>

    {{-- Main Filter & Data Table --}}
    <div class="editorial-panel bg-white overflow-hidden stagger-3">
        <div class="p-6 md:p-8 border-b border-gray-100 bg-gray-50/30">
            <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-6">
                <div>
                    <h2 class="font-display text-xl font-bold text-ink mb-1">Database Jadwal Sentral</h2>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-widest text-[11px]">Indeks Data Alokasi Waktu/Ruang Operasional</p>
                </div>

                <div class="w-full lg:w-auto space-y-4">
                    {{-- Importer Form --}}
                    <form method="POST" action="{{ route('admin.schedules.import') }}" enctype="multipart/form-data" class="flex flex-col sm:flex-row sm:items-center gap-3 w-full justify-end">
                        @csrf
                        <div class="relative w-full sm:w-auto">
                            <input type="file" name="excel_file" accept=".xlsx,.xls,.csv" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-ink hover:file:bg-gray-200 transition-colors bg-white border border-gray-200 rounded-xl" />
                        </div>
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-ink text-white text-sm font-bold hover:bg-ink/90 transition-colors shadow-sm shrink-0">
                            Sinkronisasi Dokumen Excel
                        </button>
                    </form>

                    {{-- Data Filter --}}
                    <form method="GET" action="{{ route('admin.schedules') }}" class="flex flex-col bg-white border border-gray-200 p-2 rounded-xl sm:flex-row sm:items-center gap-2 w-full shadow-sm">
                        
                        <div class="relative w-full sm:w-72 flex-none">
                            <svg class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" /></svg>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari entitas kelas/ruang..."
                                class="w-full pl-10 pr-3 py-2 text-sm font-medium border-0 focus:ring-0 outline-none placeholder:text-gray-400 text-ink bg-transparent" />
                        </div>

                        <div class="hidden sm:block w-px h-6 bg-gray-200"></div>

                        <select name="room_id" class="w-full sm:w-48 flex-none px-3 py-2 text-sm font-medium bg-transparent border-0 focus:ring-0 outline-none text-ink cursor-pointer">
                            <option value="">-- Dimensi Fasilitas --</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" {{ (string) $selectedRoomId === (string) $room->id ? 'selected' : '' }}>
                                    {{ $room->room_code ?? $room->name }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-gray-100 text-ink hover:bg-gray-200 transition-colors text-sm font-bold shrink-0" title="Proses Data">
                            Terapkan Saringan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-100 text-left">
                        <th class="px-6 py-4 font-display text-[10px] font-bold text-ink/50 uppercase tracking-widest w-1/6">Dimensi Ruang</th>
                        <th class="px-6 py-4 font-display text-[10px] font-bold text-ink/50 uppercase tracking-widest w-1/5">Afiliasi Kelas</th>
                        <th class="px-6 py-4 font-display text-[10px] font-bold text-ink/50 uppercase tracking-widest w-1/3">Mata Kuliah</th>
                        <th class="px-6 py-4 font-display text-[10px] font-bold text-ink/50 uppercase tracking-widest w-1/6">Blok Hari</th>
                        <th class="px-6 py-4 font-display text-[10px] font-bold text-ink/50 uppercase tracking-widest">Alokasi Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($schedules as $schedule)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-bold text-ink text-sm bg-gray-100 px-2.5 py-1 rounded">{{ $schedule->room?->room_code ?? ('ROOM-' . $schedule->room_id) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-orange-900 border-b-2 border-orange-100">{{ $schedule->classGroup ? ($schedule->classGroup->major === 'Umum' ? $schedule->classGroup->name : $schedule->classGroup->major . ' ' . $schedule->classGroup->name) : '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-ink">{{ $schedule->course_name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $dayLabel = match ((int) $schedule->day_of_week) {
                                        0 => 'Minggu', 1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', default => '-',
                                    };
                                @endphp
                                <span class="font-bold text-sm {{ now()->dayOfWeek == $schedule->day_of_week ? 'text-orange-600' : 'text-gray-600' }}">{{ $dayLabel }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 font-mono text-[13px] font-semibold text-gray-600">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    {{ substr((string) $schedule->start_time, 0, 5) }} &mdash; {{ substr((string) $schedule->end_time, 0, 5) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center">
                                <div class="text-gray-400 mb-2">
                                    <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                </div>
                                <p class="text-sm font-medium text-ink/50">Tidak ada matriks jadwal yang cocok dengan parameter kueri saat ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-6 py-5 border-t border-gray-100 bg-gray-50/30">
            <p class="text-[11px] font-semibold uppercase tracking-widest text-gray-500">Tampilan Data <span class="text-ink">{{ $schedules->count() }}</span> / <span class="text-ink">{{ $schedules->total() }}</span> Entri Sistem</p>
            @if($schedules->hasPages())
                <div class="flex items-center gap-1.5">
                    @if($schedules->onFirstPage())
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-300 cursor-not-allowed"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg></span>
                    @else
                        <a href="{{ $schedules->previousPageUrl() }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-ink hover:bg-white border border-transparent hover:border-gray-200 transition-all shadow-none hover:shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg></a>
                    @endif

                    @php
                        $window = 2;
                        $from = max($schedules->currentPage() - $window, 1);
                        $to = min($schedules->currentPage() + $window, $schedules->lastPage());
                    @endphp

                    @if($from > 1)
                        <a href="{{ $schedules->url(1) }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-white hover:border-gray-200 text-xs font-bold transition-all border border-transparent shadow-none hover:shadow-sm">1</a>
                        @if($from > 2) <span class="px-1 text-gray-400">...</span> @endif
                    @endif

                    @for($page = $from; $page <= $to; $page++)
                        @if($page == $schedules->currentPage())
                            <span class="w-8 h-8 rounded-lg flex items-center justify-center bg-ink text-white shadow-sm text-xs font-bold">{{ $page }}</span>
                        @else
                            <a href="{{ $schedules->url($page) }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-white hover:border-gray-200 text-xs font-bold transition-all border border-transparent shadow-none hover:shadow-sm">{{ $page }}</a>
                        @endif
                    @endfor

                    @if($to < $schedules->lastPage())
                        @if($to < $schedules->lastPage() - 1) <span class="px-1 text-gray-400">...</span> @endif
                        <a href="{{ $schedules->url($schedules->lastPage()) }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-white hover:border-gray-200 text-xs font-bold transition-all border border-transparent shadow-none hover:shadow-sm">{{ $schedules->lastPage() }}</a>
                    @endif

                    @if($schedules->hasMorePages())
                        <a href="{{ $schedules->nextPageUrl() }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-ink hover:bg-white border border-transparent hover:border-gray-200 transition-all shadow-none hover:shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg></a>
                    @else
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-300 cursor-not-allowed"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg></span>
                    @endif
                </div>
            @endif
        </div>
    </div>

@endsection