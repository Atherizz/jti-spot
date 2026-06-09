@extends('layouts.dashboard')

@section('title', 'Manajemen Jadwal')

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
                        Kelola agregasi jadwal kelas seluruh program studi, konfirmasi slot ketersediaan ruang, dan pembaruan massal via konfigurasi Excel.
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
                        <button type="button" onclick="openExcelTemplateModal()" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-700 hover:text-ink text-sm font-semibold hover:bg-gray-50 transition-colors shadow-sm shrink-0">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>Format Excel</span>
                        </button>
                        <div class="relative w-full sm:w-auto">
                            <input type="file" name="excel_file" accept=".xlsx,.xls,.csv" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-ink hover:file:bg-gray-200 transition-colors bg-white border border-gray-200 rounded-xl" />
                        </div>
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-ink text-white text-sm font-bold hover:bg-ink/90 transition-colors shadow-sm shrink-0">
                            Sinkronisasi Dokumen Excel
                        </button>
                    </form>

                    {{-- Data Filter --}}
                    <form method="GET" action="{{ route('admin.schedules') }}" class="flex flex-col bg-white border border-gray-200 p-2 rounded-xl lg:flex-row lg:items-center gap-2 w-full shadow-sm">

                        <div class="relative w-full lg:w-64 flex-none">
                            <svg class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" /></svg>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kelas, ruang, atau matkul..."
                                class="w-full pl-10 pr-3 py-2 text-sm font-medium border-0 focus:ring-0 outline-none placeholder:text-gray-400 text-ink bg-transparent" />
                        </div>

                        <div class="hidden lg:block w-px h-6 bg-gray-200"></div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 w-full lg:w-auto flex-1">
                            <!-- Ruang -->
                            <select name="room_id" class="w-full px-3 py-2 text-sm font-medium bg-transparent border border-gray-100 lg:border-0 rounded-lg lg:rounded-none focus:ring-0 outline-none text-ink cursor-pointer">
                                <option value="">-- Ruangan --</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}" {{ (string) $selectedRoomId === (string) $room->id ? 'selected' : '' }}>
                                        {{ $room->room_code ?? $room->name }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Lantai -->
                            <select name="floor" class="w-full px-3 py-2 text-sm font-medium bg-transparent border border-gray-100 lg:border-0 rounded-lg lg:rounded-none focus:ring-0 outline-none text-ink cursor-pointer">
                                <option value="">-- Lantai --</option>
                                @foreach ($floors as $flr)
                                    <option value="{{ $flr }}" {{ (string) $selectedFloor === (string) $flr ? 'selected' : '' }}>
                                        Lantai {{ $flr }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Hari -->
                            <select name="day" class="w-full px-3 py-2 text-sm font-medium bg-transparent border border-gray-100 lg:border-0 rounded-lg lg:rounded-none focus:ring-0 outline-none text-ink cursor-pointer">
                                <option value="">-- Hari --</option>
                                <option value="1" {{ (string) $selectedDay === '1' ? 'selected' : '' }}>Senin</option>
                                <option value="2" {{ (string) $selectedDay === '2' ? 'selected' : '' }}>Selasa</option>
                                <option value="3" {{ (string) $selectedDay === '3' ? 'selected' : '' }}>Rabu</option>
                                <option value="4" {{ (string) $selectedDay === '4' ? 'selected' : '' }}>Kamis</option>
                                <option value="5" {{ (string) $selectedDay === '5' ? 'selected' : '' }}>Jumat</option>
                                <option value="6" {{ (string) $selectedDay === '6' ? 'selected' : '' }}>Sabtu</option>
                                <option value="0" {{ (string) $selectedDay === '0' ? 'selected' : '' }}>Minggu</option>
                            </select>

                            <!-- Jam Mulai -->
                            <select name="start_time" class="w-full px-3 py-2 text-sm font-medium bg-transparent border border-gray-100 lg:border-0 rounded-lg lg:rounded-none focus:ring-0 outline-none text-ink cursor-pointer">
                                <option value="">-- Jam Mulai --</option>
                                @foreach ($startTimes as $time)
                                    <option value="{{ $time }}" {{ (string) $selectedTime === (string) $time ? 'selected' : '' }}>
                                        {{ $time }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center gap-1.5 justify-end shrink-0 w-full lg:w-auto mt-2 lg:mt-0">
                            @if(request()->anyFilled(['q', 'room_id', 'floor', 'day', 'start_time']))
                                <a href="{{ route('admin.schedules') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-gray-100 text-gray-500 hover:text-ink hover:bg-gray-200 transition-colors text-xs font-bold shrink-0" title="Reset Filter">
                                    Reset
                                </a>
                            @endif
                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-gray-100 text-ink hover:bg-gray-200 transition-colors text-sm font-bold shrink-0" title="Terapkan Saringan">
                                Terapkan Saringan
                            </button>
                        </div>
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

    {{-- Modal Excel Template --}}
    <div id="excelTemplateModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-ink/40 backdrop-blur-sm transition-opacity" onclick="closeExcelTemplateModal()"></div>

        <!-- Modal Container -->
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-5xl border border-gray-100 flex flex-col max-h-[90vh]">
                <!-- Header -->
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                    <div>
                        <h3 class="text-lg font-bold text-ink leading-6" id="modal-title">Format Excel Template Jadwal</h3>
                        <p class="mt-1 text-xs text-gray-500">Sesuaikan struktur kolom file Excel Anda dengan format di bawah ini agar proses sinkronisasi berhasil.</p>
                    </div>
                    <button type="button" class="rounded-lg p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors" onclick="closeExcelTemplateModal()">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Body (Scrollable) -->
                <div class="p-6 overflow-y-auto space-y-6 flex-1">
                    <!-- Excel Preview Table -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400">Pratinjau Lembar Kerja (Excel Grid)</h4>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 uppercase border border-emerald-100">Format Kolom Wajib</span>
                        </div>
                        <div class="overflow-x-auto border border-gray-200 rounded-xl shadow-inner bg-gray-50/50 p-1">
                            <table class="w-full text-xs border-collapse text-left bg-white rounded-lg overflow-hidden">
                                <thead>
                                    <!-- Excel Columns Indicator A-K -->
                                    <tr class="bg-gray-100 text-gray-400 font-mono text-center text-[10px] border-b border-gray-200 divide-x divide-gray-200">
                                        <th class="w-10 bg-gray-200/40 py-1 font-normal text-center select-none"></th>
                                        <th class="py-1 font-normal uppercase w-12">A</th>
                                        <th class="py-1 font-normal uppercase w-28">B</th>
                                        <th class="py-1 font-normal uppercase w-28">C</th>
                                        <th class="py-1 font-normal uppercase w-16">D</th>
                                        <th class="py-1 font-normal uppercase w-24">E</th>
                                        <th class="py-1 font-normal uppercase w-24">F</th>
                                        <th class="py-1 font-normal uppercase w-24">G</th>
                                        <th class="py-1 font-normal uppercase w-24">H</th>
                                        <th class="py-1 font-normal uppercase w-24">I</th>
                                        <th class="py-1 font-normal uppercase w-32">J</th>
                                        <th class="py-1 font-normal uppercase w-36">K</th>
                                    </tr>
                                    <!-- Row 1: Headers -->
                                    <tr class="bg-[#1f4e78] text-white font-semibold text-[11px] divide-x divide-[#2c5b85] border-b border-gray-300">
                                        <td class="bg-gray-100 text-gray-400 text-center font-mono text-[10px] py-2 w-10 border-r border-gray-200 select-none">1</td>
                                        <td class="px-3 py-2 font-bold whitespace-nowrap">
                                            <div class="flex items-center justify-between gap-1">
                                                <span>No</span>
                                                <svg class="w-2.5 h-2.5 text-white/70" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                            </div>
                                        </td>
                                        <td class="px-3 py-2 font-bold whitespace-nowrap">
                                            <div class="flex items-center justify-between gap-1">
                                                <span>Room</span>
                                                <svg class="w-2.5 h-2.5 text-white/70" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                            </div>
                                        </td>
                                        <td class="px-3 py-2 font-bold whitespace-nowrap">
                                            <div class="flex items-center justify-between gap-1">
                                                <span>Class Name</span>
                                                <svg class="w-2.5 h-2.5 text-white/70" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                            </div>
                                        </td>
                                        <td class="px-3 py-2 font-bold whitespace-nowrap">
                                            <div class="flex items-center justify-between gap-1">
                                                <span>Day</span>
                                                <svg class="w-2.5 h-2.5 text-white/70" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                            </div>
                                        </td>
                                        <td class="px-3 py-2 font-bold whitespace-nowrap">
                                            <div class="flex items-center justify-between gap-1">
                                                <span>Day Name</span>
                                                <svg class="w-2.5 h-2.5 text-white/70" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                            </div>
                                        </td>
                                        <td class="px-3 py-2 font-bold whitespace-nowrap">
                                            <div class="flex items-center justify-between gap-1">
                                                <span>Start Period</span>
                                                <svg class="w-2.5 h-2.5 text-white/70" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                            </div>
                                        </td>
                                        <td class="px-3 py-2 font-bold whitespace-nowrap">
                                            <div class="flex items-center justify-between gap-1">
                                                <span>End Period</span>
                                                <svg class="w-2.5 h-2.5 text-white/70" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                            </div>
                                        </td>
                                        <td class="px-3 py-2 font-bold whitespace-nowrap">
                                            <div class="flex items-center justify-between gap-1">
                                                <span>Start Time</span>
                                                <svg class="w-2.5 h-2.5 text-white/70" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                            </div>
                                        </td>
                                        <td class="px-3 py-2 font-bold whitespace-nowrap">
                                            <div class="flex items-center justify-between gap-1">
                                                <span>End Time</span>
                                                <svg class="w-2.5 h-2.5 text-white/70" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                            </div>
                                        </td>
                                        <td class="px-3 py-2 font-bold whitespace-nowrap">
                                            <div class="flex items-center justify-between gap-1">
                                                <span>Course Code</span>
                                                <svg class="w-2.5 h-2.5 text-white/70" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                            </div>
                                        </td>
                                        <td class="px-3 py-2 font-bold whitespace-nowrap">
                                            <div class="flex items-center justify-between gap-1">
                                                <span>Lecturer</span>
                                                <svg class="w-2.5 h-2.5 text-white/70" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                            </div>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <!-- Row 2 -->
                                    <tr class="divide-x divide-gray-200 font-mono text-[11px] text-gray-700">
                                        <td class="bg-gray-100 text-gray-400 text-center py-2 w-10 select-none">2</td>
                                        <td class="px-3 py-2">1</td>
                                        <td class="px-3 py-2 bg-emerald-50/20 font-bold text-ink">Ruang Teori 1</td>
                                        <td class="px-3 py-2 font-bold text-ink">TI1B</td>
                                        <td class="px-3 py-2">1</td>
                                        <td class="px-3 py-2">Senin</td>
                                        <td class="px-3 py-2">1</td>
                                        <td class="px-3 py-2">3</td>
                                        <td class="px-3 py-2">07:00</td>
                                        <td class="px-3 py-2">09:30</td>
                                        <td class="px-3 py-2 font-semibold text-gray-800">BD_TI</td>
                                        <td class="px-3 py-2 text-gray-500 font-sans">ENH</td>
                                    </tr>
                                    <!-- Row 3 -->
                                    <tr class="divide-x divide-gray-200 font-mono text-[11px] text-gray-700">
                                        <td class="bg-gray-100 text-gray-400 text-center py-2 w-10 select-none">3</td>
                                        <td class="px-3 py-2">2</td>
                                        <td class="px-3 py-2 bg-emerald-50/20 font-bold text-ink">Ruang Teori 2</td>
                                        <td class="px-3 py-2 font-bold text-ink">TI3C</td>
                                        <td class="px-3 py-2">1</td>
                                        <td class="px-3 py-2">Senin</td>
                                        <td class="px-3 py-2">2</td>
                                        <td class="px-3 py-2">5</td>
                                        <td class="px-3 py-2">07:50</td>
                                        <td class="px-3 py-2">11:20</td>
                                        <td class="px-3 py-2 font-semibold text-gray-800">KEP_TI</td>
                                        <td class="px-3 py-2 text-gray-500 font-sans">KPA</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Column Explanations / Documentation -->
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Panduan Pengisian Kolom</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="border border-gray-100 rounded-xl p-4 bg-gray-50/30">
                                <ul class="space-y-2.5 text-xs text-gray-600">
                                    <li>
                                        <strong class="text-ink">A. No:</strong>
                                        <span class="block mt-0.5 text-gray-500">Nomor urut data. Field ini opsional dan diabaikan saat sistem memproses impor.</span>
                                    </li>
                                    <li>
                                        <strong class="text-ink">B. Room:</strong>
                                        <span class="block mt-0.5 text-gray-500">Nama ruang (e.g. <code class="bg-white px-1 py-0.5 border border-gray-200 rounded">Ruang Teori 1</code> atau <code class="bg-white px-1 py-0.5 border border-gray-200 rounded">Lab Pemrograman 2</code>). Harus sama dengan nama ruang di sistem, bukan kode seperti <code class="bg-white px-1 py-0.5 border border-gray-200 rounded">RT01</code> atau <code class="bg-white px-1 py-0.5 border border-gray-200 rounded">LPR2</code>.</span>
                                    </li>
                                    <li>
                                        <strong class="text-ink">C. Class Name:</strong>
                                        <span class="block mt-0.5 text-gray-500">Nama kelas (e.g. <code class="bg-white px-1 py-0.5 border border-gray-200 rounded">TI2B</code>).</span>
                                    </li>
                                    <li>
                                        <strong class="text-ink">D. Day:</strong>
                                        <span class="block mt-0.5 text-gray-500">Kode hari angka: <code class="bg-white px-1 py-0.5 border border-gray-200 rounded">0</code> = Minggu, <code class="bg-white px-1 py-0.5 border border-gray-200 rounded">1</code> = Senin, ..., <code class="bg-white px-1 py-0.5 border border-gray-200 rounded">6</code> = Sabtu.</span>
                                    </li>
                                    <li>
                                        <strong class="text-ink">E. Day Name:</strong>
                                        <span class="block mt-0.5 text-gray-500">Nama hari teks (e.g. <code class="bg-white px-1 py-0.5 border border-gray-200 rounded">Senin</code>, <code class="bg-white px-1 py-0.5 border border-gray-200 rounded">Selasa</code>).</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="border border-gray-100 rounded-xl p-4 bg-gray-50/30">
                                <ul class="space-y-2.5 text-xs text-gray-600">
                                    <li>
                                        <strong class="text-ink">F & G. Start & End Period:</strong>
                                        <span class="block mt-0.5 text-gray-500">Jam pelajaran ke-berapa kelas dimulai dan selesai (e.g. Start: <code class="bg-white px-1 py-0.5 border border-gray-200 rounded">1</code>, End: <code class="bg-white px-1 py-0.5 border border-gray-200 rounded">6</code>).</span>
                                    </li>
                                    <li>
                                        <strong class="text-ink">H & I. Start & End Time:</strong>
                                        <span class="block mt-0.5 text-gray-500">Jam operasional mulai dan selesai kelas dengan format <code class="bg-white px-1 py-0.5 border border-gray-200 rounded">HH:MM</code> (e.g. <code class="bg-white px-1 py-0.5 border border-gray-200 rounded">07:00</code> dan <code class="bg-white px-1 py-0.5 border border-gray-200 rounded">12:10</code>).</span>
                                    </li>
                                    <li>
                                        <strong class="text-ink">J. Course Code:</strong>
                                        <span class="block mt-0.5 text-gray-500">Kode atau nama mata kuliah (e.g. <code class="bg-white px-1 py-0.5 border border-gray-200 rounded">PWL_TI</code>).</span>
                                    </li>
                                    <li>
                                        <strong class="text-ink">K. Lecturer:</strong>
                                        <span class="block mt-0.5 text-gray-500">Nama atau inisial Dosen Pengampu (opsional/informasi pelengkap).</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3 bg-gray-50/50">
                    <span class="text-xs text-gray-500 text-center sm:text-left">Pastikan tidak mengubah nama-nama header pada baris pertama.</span>
                    <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                        <button type="button" class="w-full sm:w-auto px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors" onclick="closeExcelTemplateModal()">
                            Tutup
                        </button>
                        <a href="{{ route('admin.schedules.template') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-bold hover:bg-emerald-700 transition-colors shadow-sm shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            <span>Unduh Template (.xlsx)</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for Modal -->
    <script>
        function openExcelTemplateModal() {
            const modal = document.getElementById('excelTemplateModal');
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeExcelTemplateModal() {
            const modal = document.getElementById('excelTemplateModal');
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Close on ESC keypress
        window.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeExcelTemplateModal();
            }
        });
    </script>

@endsection
