@extends('layouts.dashboard')

@section('title', 'Pusat Aksi')

@section('content')

    {{-- Flash Messages --}}
    @if(session('error'))
    <div id="flashMessage" class="mb-8 w-full bg-red-50 border border-red-100 rounded-2xl p-4 flex items-start gap-4 shadow-sm">
        <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center shrink-0 mt-0.5 text-red-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </div>
        <div class="flex-1 min-w-0">
            <p class="font-semibold text-red-900 text-sm">Kesalahan Sistem</p>
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
    <div class="mb-10 stagger-1">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></div>
            <span class="font-display font-semibold uppercase tracking-widest text-[11px] text-ink/50">Terminal Mahasiswa</span>
        </div>
        <h1 class="font-display text-3xl sm:text-4xl font-bold tracking-tight text-ink mb-3 leading-tight">Pusat Aksi</h1>
        <p class="text-sm font-medium text-ink/60 max-w-xl leading-relaxed">
            Kelola permintaan akademik Anda — dari reservasi ruangan kelas hingga pembatalan jadwal yang terencana.
        </p>
    </div>

    {{-- Info Banner --}}
    <div class="editorial-panel bg-orange-50/50 relative overflow-hidden mb-10 stagger-2 group">
        <div class="absolute -right-12 -top-12 w-48 h-48 bg-white/40 rounded-full blur-2xl pointer-events-none group-hover:bg-white/60 transition-colors"></div>
        <div class="p-5 relative z-10 flex gap-4 items-start">
            <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center shrink-0 shadow-[inset_0_1px_1px_rgba(255,255,255,0.5)] border border-orange-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h3 class="font-display font-bold text-base text-orange-900 mb-1 tracking-tight">Panduan Penggunaan Pusat Aksi</h3>
                <p class="text-sm font-medium text-orange-800/80 leading-relaxed max-w-2xl">
                    Reservasi ruangan dilakukan <strong>H-1 atau H-2</strong> sebelum jadwal kelas dimulai. Pembatalan kelas harus diajukan setidaknya <strong>24 jam sebelumnya</strong> dan akan memerlukan persetujuan dari pihak akademik.
                </p>
            </div>
        </div>
    </div>

    {{-- Mode Notifikasi Peluang Ruang --}}
    <div class="editorial-panel bg-white relative overflow-hidden mb-10 stagger-2 group">
        <div class="absolute -right-14 -top-14 w-52 h-52 bg-orange-50 rounded-full blur-3xl opacity-70 pointer-events-none"></div>
        <div class="p-6 md:p-7 relative z-10">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="flex gap-4 items-start min-w-0">
                    <div class="w-12 h-12 rounded-2xl {{ $roomOpportunityAlertEnabled ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-gray-50 text-gray-400 border-gray-100' }} flex items-center justify-center shrink-0 border shadow-sm">
                        @if($roomOpportunityAlertEnabled)
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0a3 3 0 11-6 0m6 0H9" />
                            </svg>
                        @else
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18.364 5.636l-12.728 12.728M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a5.972 5.972 0 00-1.012-3.335M12 5a6 6 0 00-6 6v3.159c0 .538-.214 1.055-.595 1.436L4 17h8m3 0a3 3 0 01-5.236 2" />
                            </svg>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest border {{ $roomOpportunityAlertEnabled ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-gray-50 text-gray-500 border-gray-100' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $roomOpportunityAlertEnabled ? 'bg-emerald-500' : 'bg-gray-300' }}"></span>
                                {{ $roomOpportunityAlertEnabled ? 'Mode Aktif' : 'Mode Nonaktif' }}
                            </span>
                            <span class="text-[10px] font-bold uppercase tracking-widest text-ink/40">WhatsApp Opportunity Alert</span>
                        </div>
                        <h2 class="font-display text-xl md:text-2xl font-bold text-ink tracking-tight mb-2">Mode Cari Ruang Kosong</h2>
                        <p class="text-sm font-medium text-ink/60 leading-relaxed max-w-2xl">
                            Jika aktif, perwakilan kelas akan menerima WhatsApp saat ada slot ruang dari pembatalan kelas lain. Slot yang bentrok jadwal tetap dikirim, tapi akan diberi label bentrok agar bisa diputuskan oleh kelas Anda.
                        </p>
                        @if(!$hasWhatsAppNumber)
                            <p class="mt-3 text-xs font-semibold text-red-600">
                                Nomor WhatsApp belum tersedia di profil Anda. Lengkapi nomor sebelum mengaktifkan mode ini.
                            </p>
                        @endif
                    </div>
                </div>

                <div class="shrink-0 w-full lg:w-auto">
                    @if($hasWhatsAppNumber)
                        <form action="{{ route('student.action.opportunity-alert-mode') }}" method="POST" class="w-full lg:w-auto">
                            @csrf
                            <input type="hidden" name="enabled" value="{{ $roomOpportunityAlertEnabled ? 0 : 1 }}">
                            <button type="submit"
                                aria-pressed="{{ $roomOpportunityAlertEnabled ? 'true' : 'false' }}"
                                class="w-full lg:w-auto min-h-[48px] px-5 py-3 rounded-xl text-sm font-semibold transition-all flex items-center justify-center gap-2 border shadow-sm {{ $roomOpportunityAlertEnabled ? 'bg-white hover:bg-gray-50 text-ink border-gray-200' : 'bg-orange-600 hover:bg-orange-700 text-white border-orange-500 shadow-orange-600/20' }}">
                                @if($roomOpportunityAlertEnabled)
                                    Nonaktifkan Mode
                                @else
                                    Aktifkan Mode
                                @endif
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('profile.show') }}"
                            class="w-full lg:w-auto min-h-[48px] px-5 py-3 rounded-xl bg-white hover:bg-gray-50 text-ink border border-gray-200 text-sm font-semibold transition-colors flex items-center justify-center gap-2 shadow-sm">
                            Lengkapi Nomor WA
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Action Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 stagger-3">

        {{-- Card: Reservasi Ruangan --}}
        <a href="{{ route('student.action.reservasi') }}" id="card-reservasi"
            class="group editorial-panel bg-white relative overflow-hidden flex flex-col transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-orange-500/10 hover:border-orange-200/80">

            {{-- Decorative background gradient --}}
            <div class="absolute inset-0 bg-gradient-to-br from-orange-50/0 via-orange-50/0 to-orange-50/80 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-orange-100/40 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>

            <div class="p-7 relative z-10 flex flex-col flex-1">
                {{-- Icon + Badge --}}
                <div class="flex items-start justify-between mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center shadow-[inset_0_1px_1px_rgba(255,255,255,0.6)] border border-orange-200 group-hover:bg-orange-500 group-hover:text-white group-hover:border-orange-500 transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-orange-50 text-orange-600 border border-orange-100 rounded-full text-[10px] font-bold uppercase tracking-widest">
                        <span class="w-1 h-1 rounded-full bg-orange-500"></span>
                        H-1 / H-2
                    </span>
                </div>

                {{-- Content --}}
                <div class="flex-1">
                    <p class="font-display text-[11px] font-semibold uppercase tracking-widest text-ink/40 mb-1.5">Manajemen Ruangan</p>
                    <h2 class="font-display text-2xl font-bold text-ink tracking-tight mb-3 leading-tight">Reservasi Ruangan Kelas</h2>
                    <p class="text-sm font-medium text-ink/60 leading-relaxed">
                        Ajukan reservasi ruangan untuk jadwal kelas Anda di masa mendatang. Pastikan pengajuan dilakukan satu atau dua hari sebelum sesi berlangsung.
                    </p>
                </div>

                {{-- Feature chips --}}
                <div class="mt-6 flex flex-wrap gap-2">
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-50 border border-gray-100 rounded-lg text-[11px] font-semibold text-ink/60">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Pengajuan Terencana
                    </span>
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-50 border border-gray-100 rounded-lg text-[11px] font-semibold text-ink/60">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Validasi Sistem
                    </span>
                </div>

                {{-- CTA --}}
                <div class="mt-6 pt-6 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-sm font-semibold text-orange-600 group-hover:text-orange-700 transition-colors">Buka Formulir Reservasi</span>
                    <div class="w-8 h-8 rounded-full bg-orange-50 border border-orange-100 flex items-center justify-center text-orange-500 group-hover:bg-orange-500 group-hover:text-white group-hover:border-orange-500 group-hover:translate-x-0.5 transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </div>
        </a>

        {{-- Card: Pembatalan Kelas --}}
        <a href="{{ route('student.action.pembatalan') }}" id="card-pembatalan"
            class="group editorial-panel bg-white relative overflow-hidden flex flex-col transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-red-500/10 hover:border-red-200/80">

            {{-- Decorative background gradient --}}
            <div class="absolute inset-0 bg-gradient-to-br from-red-50/0 via-red-50/0 to-red-50/80 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-red-100/40 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>

            <div class="p-7 relative z-10 flex flex-col flex-1">
                {{-- Icon + Badge --}}
                <div class="flex items-start justify-between mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-red-50 text-red-500 flex items-center justify-center shadow-[inset_0_1px_1px_rgba(255,255,255,0.6)] border border-red-100 group-hover:bg-red-500 group-hover:text-white group-hover:border-red-500 transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 text-red-600 border border-red-100 rounded-full text-[10px] font-bold uppercase tracking-widest">
                        <span class="w-1 h-1 rounded-full bg-red-500"></span>
                        Min. 24 Jam
                    </span>
                </div>

                {{-- Content --}}
                <div class="flex-1">
                    <p class="font-display text-[11px] font-semibold uppercase tracking-widest text-ink/40 mb-1.5">Manajemen Jadwal</p>
                    <h2 class="font-display text-2xl font-bold text-ink tracking-tight mb-3 leading-tight">Pembatalan Jadwal Kelas</h2>
                    <p class="text-sm font-medium text-ink/60 leading-relaxed">
                        Ajukan permohonan pembatalan sesi kelas yang terdaftar dalam jadwal Anda. Setiap pengajuan akan melalui proses verifikasi oleh pihak akademik.
                    </p>
                </div>

                {{-- Feature chips --}}
                <div class="mt-6 flex flex-wrap gap-2">
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-50 border border-gray-100 rounded-lg text-[11px] font-semibold text-ink/60">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Perlu Persetujuan
                    </span>
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-50 border border-gray-100 rounded-lg text-[11px] font-semibold text-ink/60">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Justifikasi Wajib
                    </span>
                </div>

                {{-- CTA --}}
                <div class="mt-6 pt-6 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-sm font-semibold text-red-600 group-hover:text-red-700 transition-colors">Buka Formulir Pembatalan</span>
                    <div class="w-8 h-8 rounded-full bg-red-50 border border-red-100 flex items-center justify-center text-red-500 group-hover:bg-red-500 group-hover:text-white group-hover:border-red-500 group-hover:translate-x-0.5 transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </div>
        </a>

    </div>

    {{-- Status Pengajuan Terbaru (Riwayat ringkas) --}}
    <div class="mt-10 stagger-4">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-display text-lg font-bold tracking-tight text-ink">Riwayat Pengajuan Terbaru</h2>
            <a href="{{ route('student.action.history') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-orange-600 hover:text-orange-700 transition-colors">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="editorial-panel bg-white overflow-hidden">
            @forelse($recentRequests ?? [] as $request)
            <div class="flex items-center gap-4 p-5 {{ !$loop->last ? 'border-b border-gray-50' : '' }} hover:bg-gray-50/50 transition-colors group">
                {{-- Type Icon --}}
                <div class="shrink-0 w-10 h-10 rounded-xl flex items-center justify-center
                    {{ $request['type'] === 'reservasi' ? 'bg-orange-50 text-orange-500 border border-orange-100' : 'bg-red-50 text-red-500 border border-red-100' }}">
                    @if($request['type'] === 'reservasi')
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    @else
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                    @endif
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-ink text-sm truncate">{{ $request['title'] }}</p>
                    <p class="text-xs text-ink/50 font-medium mt-0.5">{{ $request['date'] }}</p>
                </div>

                <!-- Status Badge Removed -->
            </div>
            @empty
            <div class="p-10 text-center">
                <div class="w-14 h-14 bg-gray-50 border border-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm text-gray-300">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="font-display font-semibold text-ink text-sm mb-1">Belum Ada Riwayat</h3>
                <p class="text-xs font-medium text-ink/50 max-w-xs mx-auto">Riwayat pengajuan reservasi dan pembatalan kelas akan muncul di sini.</p>
            </div>
            @endforelse
        </div>
    </div>

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
