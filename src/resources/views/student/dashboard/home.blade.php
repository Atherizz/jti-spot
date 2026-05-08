@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')

    {{-- Soft Editorial Flash Messages --}}
    @if(session('error'))
    <div id="flashMessage" class="mb-8 w-full bg-red-50 border border-red-100 rounded-2xl p-4 flex items-start gap-4 shadow-sm">
        <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center shrink-0 mt-0.5 text-red-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </div>
        <div class="flex-1 min-w-0">
            <p class="font-semibold text-red-900 text-sm">Sistem Error</p>
            <p class="text-sm text-red-700 mt-0.5">{{ session('error') }}</p>
        </div>
        <button onclick="document.getElementById('flashMessage').remove()" class="text-red-400 hover:text-red-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>
    @endif

    @if(session('success'))
    <div id="flashMessage" class="mb-8 w-full bg-emerald-50 border border-emerald-100 rounded-2xl p-4 flex items-start gap-4 shadow-sm">
        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0 mt-0.5 text-emerald-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
        </div>
        <div class="flex-1 min-w-0">
            <p class="font-semibold text-emerald-900 text-sm">Berhasil</p>
            <p class="text-sm text-emerald-700 mt-0.5">{{ session('success') }}</p>
        </div>
        <button onclick="document.getElementById('flashMessage').remove()" class="text-emerald-400 hover:text-emerald-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>
    @endif

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8 stagger-1">
        <div>   
            <div class="flex items-center gap-2 mb-2">
                <span class="inline-block w-2.5 h-2.5 rounded-full bg-orange-500"></span>
                <span class="font-display text-[11px] font-bold uppercase tracking-widest text-ink/50">Terminal Mahasiswa</span>
            </div>
            <h1 class="font-display text-4xl sm:text-5xl font-bold tracking-tight text-ink leading-none">
                Dashboard
            </h1>
            <p class="text-base text-ink/60 mt-3 md:mt-2">Selamat datang kembali, <span class="font-semibold text-ink">{{ auth()->user()->name }}</span>.</p>
        </div>
    </div>

    {{-- Grid Utama (Formal Panels) --}}
    <div class="flex flex-col xl:flex-row gap-6 mb-8 stagger-2">

        {{-- Sesi Saat Ini (Soft Instrument Panel) --}}
        <div class="xl:w-2/5 flex flex-col order-first xl:order-last">
            <div class="bg-ink text-white editorial-panel border-none p-6 md:p-8 flex flex-col h-full relative overflow-hidden group">
                <div class="absolute inset-0 opacity-20 pointer-events-none" style="background-image: radial-gradient(circle at top right, rgba(255,255,255,0.4), transparent 50%);"></div>
                
                <div class="relative z-10 flex flex-col flex-1">
                    <div class="flex items-center justify-between pb-4 mb-6 border-b border-white/10">
                        <span class="font-display text-xs font-semibold uppercase tracking-widest text-white/60">Sesi Akademik Saat Ini</span>
                        <div class="flex items-center gap-1.5 px-2.5 py-1 bg-emerald-500/20 border border-emerald-500/30 rounded-full">
                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-ping"></span>
                            <span class="text-[10px] font-semibold text-emerald-300">Live</span>
                        </div>
                    </div>

                    <h2 class="font-display text-2xl sm:text-3xl font-bold leading-tight mb-2">{{ $sessionTitle }}</h2>
                    <p class="text-sm text-white/60 mb-6">{{ $sessionMeta }}</p>

                    <div class="bg-white/5 border border-white/10 rounded-xl p-4 flex items-center justify-between mb-8 backdrop-blur-sm">
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-widest text-white/50 mb-0.5">Lokasi Kelas</p>
                            <p class="font-semibold text-sm">{{ $sessionLocation }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                    </div>

                    <div class="mb-8">
                        <div class="flex items-center justify-between text-xs mb-2">
                            <span class="font-medium text-white/60">Pengumpulan Radar</span>
                            <span class="font-semibold text-emerald-300">{{ $currentQuorum }} / {{ $quorumSize }}</span>
                        </div>
                        <div class="w-full bg-white/10 rounded-full h-1.5">
                            <div class="bg-gradient-to-r from-orange-400 to-orange-500 h-full rounded-full relative" style="width: {{ $progressPercent }}%"></div>
                        </div>
                    </div>

                    <div class="mt-auto">
                        @if($canManualCheckIn && !$alreadyScanned)
                        <button class="w-full bg-white/5 text-white/40 border border-white/5 font-medium text-sm py-3.5 rounded-xl cursor-not-allowed">
                            Silakan Scan QR Code di Ruangan
                        </button>
                        @elseif($alreadyScanned)
                        <div class="flex items-stretch gap-2">
                            <a href="{{ $checkInPageUrl ?? '#' }}" class="flex-1 bg-white/10 text-white font-medium text-sm py-3 px-4 rounded-xl {{ $checkInPageUrl ? 'hover:bg-white/20 transition-colors' : 'opacity-50 pointer-events-none' }} flex items-center justify-center gap-2 border border-white/10">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Kehadiran Tercatat
                            </a>
                        </div>
                        @else
                        <button class="w-full bg-white/5 text-white/40 border border-white/5 font-medium text-sm py-3.5 rounded-xl cursor-not-allowed">
                            Tidak Ada Sesi Aktif Saat Ini
                        </button>
                        @endif

                        @if(auth()->user()->role === 'class_rep' && $canManualCheckIn && !$sessionIsOccupied)
                            @if($quorumExtendedUntil && $quorumExtendedUntil->isFuture())
                            <div class="mt-3 flex items-center gap-2 px-3 py-2.5 bg-amber-500/10 border border-amber-500/20 rounded-xl">
                                <svg class="w-4 h-4 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span class="text-xs font-medium text-amber-300">Diperpanjang s/d {{ $quorumExtendedUntil->format('H:i') }}</span>
                            </div>
                            @else
                            <button type="button"
                                onclick="document.getElementById('extendQuorumModal').classList.remove('hidden')"
                                class="mt-3 w-full bg-amber-500/10 hover:bg-amber-500/20 text-amber-300 border border-amber-500/20 font-medium text-sm py-3 rounded-xl transition-colors flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Kelas Terlambat
                            </button>
                            @endif
                        @endif

                        @if(auth()->user()->role === 'class_rep' && $canManualCheckIn && $sessionIsOccupied)
                        <form id="endSessionForm" action="{{ route('student.session.end') }}" method="POST" class="mt-3">
                            @csrf
                            <button type="button"
                                onclick="document.getElementById('endSessionModal').classList.remove('hidden')"
                                class="w-full bg-red-500/10 hover:bg-red-500/20 text-red-300 border border-red-500/20 font-medium text-sm py-3 rounded-xl transition-colors flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" /></svg>
                                Akhiri Sesi Kelas Ini
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Aktivitas Crowdsourcing (Editorial Timeline softly styled) --}}
        <div class="xl:w-3/5 editorial-panel bg-white p-6 md:p-8 flex flex-col">
            <div class="flex items-end justify-between border-b border-gray-100 pb-5 mb-6">
                <div>
                    <h2 class="font-display text-xl font-bold tracking-tight text-ink">Timeline Ketersediaan</h2>
                    <p class="font-medium text-xs text-ink/50 mt-1">Laporan Langsung dari Jaringan</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                </div>
            </div>

            <div class="flex-1 relative">
                <!-- Soft Timeline Line -->
                <div class="absolute left-[11px] top-4 bottom-4 w-px bg-gray-100"></div>

                <div class="space-y-6 relative z-10 py-2">
                    @forelse($activities as $activity)
                    <div class="flex items-start gap-5 group">
                        <div class="w-6 h-6 shrink-0 rounded-full bg-white border-2 flex items-center justify-center mt-1 {{ $activity['type'] === 'QUORUM_REACHED' ? 'border-emerald-500 text-emerald-500' : 'border-gray-200 text-gray-300' }} group-hover:scale-110 transition-transform relative z-20">
                            @if($activity['type'] === 'QUORUM_REACHED')
                                <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                            @else
                                <div class="w-1.5 h-1.5 bg-gray-300 rounded-full"></div>
                            @endif
                        </div>
                        <div>
                            <p class="font-medium text-ink leading-tight">{{ $activity['title'] }}</p>
                            <p class="text-sm text-ink/50 mt-1">{{ $activity['subtitle'] }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="border border-dashed border-gray-200 rounded-2xl p-8 text-center bg-gray-50/50">
                        <p class="font-medium text-ink/60 text-sm">Belum ada sinyal crowdsourcing yang tercatat pada kelas Anda.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            @if($totalActivities > count($activities) && count($activities) > 0)
            <div class="mt-8 pt-5 border-t border-gray-100 text-center">
                <a href="{{ route('student.activity.log') }}" class="inline-flex items-center gap-1.5 font-medium text-sm text-orange-600 hover:text-orange-700 transition-colors">
                    Lihat Semua Aktivitas ({{ $totalActivities }})
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </a>
            </div>
            @endif
        </div>
    </div>

    {{-- Statistik Kontribusi (Soft Cards) --}}
    <div class="stagger-3 mb-10">
        <h2 class="font-display text-lg font-bold tracking-tight mb-4">Statistik Kontribusi</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="editorial-panel bg-white p-6 flex flex-col h-full justify-between gap-4 group hover:bg-gray-50/50">
                <div class="flex items-center justify-between">
                    <p class="font-display text-[11px] font-semibold uppercase tracking-widest text-ink/50">Total Partisipasi Awal</p>
                    <div class="w-8 h-8 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    </div>
                </div>
                <p class="font-display text-4xl font-bold text-ink">{{ $weeklyScans }}</p>
            </div>

            <div class="editorial-panel bg-white p-6 flex flex-col h-full justify-between gap-4 group hover:bg-gray-50/50">
                <div class="flex items-center justify-between">
                    <p class="font-display text-[11px] font-semibold uppercase tracking-widest text-ink/50">Ruang Dikonfirmasi</p>
                    <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
                <p class="font-display text-4xl font-bold text-emerald-600">{{ $verifiedRooms }}</p>
            </div>

            <div class="editorial-panel bg-white p-6 flex flex-col h-full justify-between gap-4 group hover:bg-gray-50/50">
                <div class="flex items-center justify-between">
                    <p class="font-display text-[11px] font-semibold uppercase tracking-widest text-ink/50">Streak Saat Ini</p>
                    <div class="w-8 h-8 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" /></svg>
                    </div>
                </div>
                <p class="font-display text-4xl font-bold text-ink">{{ $streakDays }}<span class="text-sm font-medium text-gray-400 ml-1">Hari</span></p>
            </div>
        </div>
    </div>

    {{-- Modal Kelas Terlambat --}}
    @if(auth()->user()->role === 'class_rep' && $canManualCheckIn && !$sessionIsOccupied)
    <div id="extendQuorumModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="document.getElementById('extendQuorumModal').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <h3 class="font-bold text-ink text-base">Kelas Terlambat Mulai</h3>
                    <p class="text-xs text-ink/50">Perpanjang window kuorum</p>
                </div>
            </div>
            <p class="text-sm text-ink/70 mb-5">Ruangan <span class="font-semibold text-ink">{{ $sessionLocation }}</span> akan tetap berstatus <span class="font-semibold text-amber-600">Menunggu</span> selama durasi yang dipilih.</p>
            <div class="flex flex-col gap-2">
                @foreach([15, 30, 45] as $minutes)
                <form action="{{ route('student.session.extend-quorum') }}" method="POST">
                    @csrf
                    <input type="hidden" name="delay_minutes" value="{{ $minutes }}">
                    <button type="submit" class="w-full bg-amber-50 hover:bg-amber-100 border border-amber-200 text-amber-800 font-medium text-sm py-2.5 rounded-xl transition-colors text-left px-4 flex items-center justify-between">
                        <span>Terlambat +{{ $minutes }} menit</span>
                        <span class="text-xs text-amber-500">s/d {{ now()->addMinutes($minutes)->format('H:i') }}</span>
                    </button>
                </form>
                @endforeach
            </div>
            <button type="button"
                onclick="document.getElementById('extendQuorumModal').classList.add('hidden')"
                class="mt-3 w-full bg-gray-100 hover:bg-gray-200 text-ink font-medium text-sm py-2.5 rounded-xl transition-colors">
                Batal
            </button>
        </div>
    </div>
    @endif

    {{-- Modal Konfirmasi Akhiri Sesi --}}
    @if(auth()->user()->role === 'class_rep' && $canManualCheckIn && $sessionIsOccupied)
    <div id="endSessionModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="document.getElementById('endSessionModal').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" /></svg>
                </div>
                <div>
                    <h3 class="font-bold text-ink text-base">Akhiri Sesi Kelas?</h3>
                    <p class="text-xs text-ink/50">Tindakan ini tidak dapat dibatalkan</p>
                </div>
            </div>
            <p class="text-sm text-ink/70 mb-6">Ruangan <span class="font-semibold text-ink">{{ $sessionLocation }}</span> akan ditandai sebagai <span class="font-semibold text-green-600">Tersedia</span> dan dapat langsung digunakan oleh kelas lain.</p>
            <div class="flex gap-3">
                <button type="button"
                    onclick="document.getElementById('endSessionModal').classList.add('hidden')"
                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-ink font-medium text-sm py-2.5 rounded-xl transition-colors">
                    Batal
                </button>
                <button type="button"
                    onclick="document.getElementById('endSessionForm').submit()"
                    class="flex-1 bg-red-600 hover:bg-red-700 text-white font-medium text-sm py-2.5 rounded-xl transition-colors">
                    Ya, Akhiri Sesi
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Auto-dismiss flash messages --}}
    @if(session('error') || session('success'))
    <script>
        setTimeout(function() {
            const flashMessage = document.getElementById('flashMessage');
            if (flashMessage) {
                flashMessage.style.transition = 'all 0.4s cubic-bezier(0.16, 1, 0.3, 1)';
                flashMessage.style.opacity = '0';
                flashMessage.style.transform = 'translateY(-10px)';
                setTimeout(() => flashMessage.remove(), 400);
            }
        }, 5000);
    </script>
    @endif

@endsection
