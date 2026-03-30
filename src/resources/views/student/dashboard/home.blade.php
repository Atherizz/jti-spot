@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')

    {{-- Flash Messages --}}
    @if(session('error'))
    <div id="flashMessage" class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-3 shadow-sm">
        <div class="w-5 h-5 rounded-full bg-red-500 flex items-center justify-center shrink-0 mt-0.5">
            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-red-900">Error</p>
            <p class="text-sm text-red-700 mt-0.5">{{ session('error') }}</p>
        </div>
        <button onclick="document.getElementById('flashMessage').remove()" class="text-red-400 hover:text-red-600 transition-colors shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    @endif

    @if(session('success'))
    <div id="flashMessage" class="mb-6 bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-start gap-3 shadow-sm">
        <div class="w-5 h-5 rounded-full bg-emerald-500 flex items-center justify-center shrink-0 mt-0.5">
            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-emerald-900">Berhasil</p>
            <p class="text-sm text-emerald-700 mt-0.5">{{ session('success') }}</p>
        </div>
        <button onclick="document.getElementById('flashMessage').remove()" class="text-emerald-400 hover:text-emerald-600 transition-colors shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    @endif

    {{-- Page Header --}}
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-indigo-900">Dashboard Mahasiswa</h1>
            <p class="text-sm text-gray-500 mt-1">
                Selamat datang, {{ auth()->user()->name }}. Ini yang sedang terjadi di kampus.
            </p>
        </div>
        {{-- Notifikasi (desktop only) --}}
        <button class="hidden lg:flex relative items-center justify-center w-10 h-10 rounded-full bg-white border border-gray-200 shadow-sm text-gray-500 hover:text-gray-700 transition-colors shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
        </button>
    </div>

    {{-- Grid Utama --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 sm:gap-6 mb-6">

        {{-- Aktivitas Crowdsourcing --}}
        <div class="lg:col-span-3 bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100">
            <div class="flex items-center gap-2 mb-5">
                <div class="w-7 h-7 rounded-lg bg-red-50 flex items-center justify-center">
                    <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                </div>
                <h2 class="text-base font-bold text-gray-900">Aktivitas Crowdsourcing</h2>
            </div>

            <div class="space-y-3">
                @forelse($activities as $activity)
                <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                    <div class="w-9 h-9 rounded-xl {{ $activity['type'] === 'QUORUM_REACHED' ? 'bg-emerald-50 border border-emerald-100' : 'bg-white border border-gray-200' }} flex items-center justify-center shrink-0 shadow-sm">
                        @if($activity['type'] === 'QUORUM_REACHED')
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        @else
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 3.5a.5.5 0 11-1 0 .5.5 0 011 0z" />
                        </svg>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-800">{{ $activity['title'] }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $activity['subtitle'] }}</p>
                    </div>
                </div>
                @empty
                <div class="p-3 rounded-xl bg-gray-50 text-sm text-gray-500">
                    Belum ada aktivitas untuk kelas Anda saat ini.
                </div>
                @endforelse

                @if($totalActivities > count($activities) && count($activities) > 0)
                <a href="{{ route('student.activity.log') }}" class="block mt-4 p-3 rounded-xl text-center bg-indigo-50 hover:bg-indigo-100 transition-colors text-sm font-medium text-indigo-600 border border-indigo-200">
                    Lihat Semua Aktivitas ({{ $totalActivities }} total)
                </a>
                @endif
            </div>
        </div>

        {{-- Sesi Saat Ini --}}
        <div class="lg:col-span-2 bg-[#1e2333] rounded-2xl p-5 sm:p-6 text-white flex flex-col shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Sesi Saat Ini</span>
                <span class="inline-flex items-center gap-1.5 bg-emerald-500/20 text-emerald-400 text-xs font-semibold px-2.5 py-1 rounded-full border border-emerald-500/30">
                    <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                    Berlangsung
                </span>
            </div>

            <h2 class="text-xl sm:text-2xl font-extrabold mb-1 leading-tight">{{ $sessionTitle }}</h2>
            <p class="text-sm text-gray-400 mb-5">{{ $sessionMeta }}</p>

            <div class="bg-white/10 rounded-xl p-3 flex items-center gap-3 mb-5">
                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Lokasi</p>
                    <p class="text-sm font-semibold">{{ $sessionLocation }}</p>
                </div>
            </div>

            <div class="mb-5">
                <div class="flex items-center justify-between text-xs mb-2">
                    <span class="text-gray-400 font-medium">Live Quorum Tracker</span>
                    <span class="text-white font-semibold">{{ $currentQuorum }}/{{ $quorumSize }} Scan terkumpul</span>
                </div>
                <div class="w-full bg-white/10 rounded-full h-2">
                    <div class="bg-orange-500 h-2 rounded-full" style="width: {{ $progressPercent }}%"></div>
                </div>
            </div>

            @if($canManualCheckIn && !$alreadyScanned)
            <form method="POST" action="{{ route('student.attendance.confirm') }}" class="mt-auto">
                @csrf
                <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 active:bg-orange-700 text-white font-bold py-3 rounded-xl flex items-center justify-center gap-2 transition-colors text-sm">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7" />
                    </svg>
                    Konfirmasi Hadir Sekarang
                </button>
            </form>
            @elseif($alreadyScanned)
            <div class="mt-auto flex items-center gap-2">
                <a href="{{ $checkInPageUrl ?? '#' }}" class="flex-1 bg-emerald-500/80 hover:bg-emerald-500 text-white font-bold py-3 rounded-xl flex items-center justify-center gap-2 text-sm transition-colors {{ $checkInPageUrl ? '' : 'pointer-events-none opacity-70' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Kehadiran Sudah Tercatat
                </a>

                <a href="{{ $checkInPageUrl ?? '#' }}" class="w-11 h-11 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 flex items-center justify-center shrink-0 transition-colors {{ $checkInPageUrl ? '' : 'pointer-events-none opacity-70' }}" title="Buka halaman check-in">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>
            @else
            <button class="mt-auto w-full bg-gray-500/50 text-gray-200 font-bold py-3 rounded-xl flex items-center justify-center gap-2 text-sm cursor-not-allowed" disabled>
                Tidak Ada Sesi Aktif
            </button>
            @endif
        </div>
    </div>

    {{-- Statistik Kontribusi --}}
    <div>
        <h2 class="text-base font-bold text-gray-800 mb-3">Statistik Kontribusi</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl bg-indigo-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 3.5a.5.5 0 11-1 0 .5.5 0 011 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Total Scan Minggu Ini</p>
                    <p class="text-2xl font-extrabold text-indigo-900">{{ $weeklyScans }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Ruang Terverifikasi</p>
                    <p class="text-2xl font-extrabold text-indigo-900">{{ $verifiedRooms }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl bg-orange-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Streak Saat Ini</p>
                    <p class="text-2xl font-extrabold text-indigo-900">{{ $streakDays }} hari</p>
                </div>
            </div>

        </div>
    </div>

    {{-- Auto-dismiss flash messages --}}
    @if(session('error') || session('success'))
    <script>
        setTimeout(function() {
            const flashMessage = document.getElementById('flashMessage');
            if (flashMessage) {
                flashMessage.style.transition = 'opacity 0.3s ease-out';
                flashMessage.style.opacity = '0';
                setTimeout(() => flashMessage.remove(), 300);
            }
        }, 5000);
    </script>
    @endif

@endsection
