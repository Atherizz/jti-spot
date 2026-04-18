@extends('layouts.dashboard')

@section('title', 'Check-in Berhasil')

@section('content')
<div class="flex items-center justify-center min-h-[calc(100vh-140px)] stagger-1 border-gray-100 p-4">
    <div class="editorial-panel bg-white shadow-2xl rounded-[2rem] w-full max-w-3xl overflow-hidden relative group">
        {{-- Abstract background --}}
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-emerald-50 rounded-full blur-3xl opacity-60 pointer-events-none"></div>

        <div class="p-8 sm:p-10 relative z-10">
            <div class="flex flex-col items-center text-center mb-10">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-500 text-white flex items-center justify-center mb-5 shadow-[0_0_20px_rgba(16,185,129,0.3)] border border-emerald-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h1 class="font-display text-3xl sm:text-4xl font-bold tracking-tight text-ink mb-2">Check-in Berhasil</h1>
                <p class="text-sm font-medium text-gray-500">Log kehadiran kampus Anda berhasil tercatat di sistem pusat.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-gray-50/80 border border-gray-100 rounded-2xl p-5 sm:p-6 mb-10">
                <div>
                    <p class="text-[11px] font-semibold tracking-widest uppercase text-gray-400">Ruang / Area</p>
                    <p class="text-base font-bold text-ink mt-1">{{ $room->name }}</p>
                </div>
                <div>
                    <p class="text-[11px] font-semibold tracking-widest uppercase text-gray-400">Parameter Log</p>
                    <p class="text-base font-bold text-ink mt-1">{{ $subjectName }}</p>
                </div>
                <div>
                    <p class="text-[11px] font-semibold tracking-widest uppercase text-gray-400">Grup Afiliasi</p>
                    <p class="text-base font-bold text-ink mt-1">{{ $className }}</p>
                </div>
                <div>
                    <p class="text-[11px] font-semibold tracking-widest uppercase text-gray-400">Status Entri</p>
                    <div class="flex items-center gap-1.5 mt-1">
                        <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                        <p class="text-base font-bold text-emerald-600">Tervalidasi Hadir</p>
                    </div>
                </div>
                <div class="sm:col-span-2 pt-4 mt-2 border-t border-gray-100">
                    <p class="text-[11px] font-semibold tracking-widest uppercase text-gray-400">Waktu Stempel Check-in</p>
                    <p class="text-lg font-bold text-ink mt-1">
                        {{ $checkedInAt ? \Carbon\Carbon::parse($checkedInAt)->format('d F Y, H:i:s') : '-' }}
                    </p>
                </div>
            </div>

            <div class="mb-10 text-center relative max-w-sm mx-auto">
                <p class="text-[10px] font-semibold uppercase tracking-widest text-ink/40 mb-3">Waktu Sisa Kuorum Kelas</p>
                <div id="countdown" class="flex items-center justify-center gap-3">
                    <div class="w-20 h-20 rounded-2xl bg-white border border-gray-200 flex flex-col justify-center items-center shadow-sm">
                        <span id="cd-h" class="font-display text-2xl font-bold text-ink">00</span>
                        <span class="text-[10px] font-medium text-gray-400 mt-1">Jam</span>
                    </div>
                    <span class="text-xl font-bold text-gray-300">:</span>
                    <div class="w-20 h-20 rounded-2xl bg-white border border-gray-200 flex flex-col justify-center items-center shadow-sm">
                        <span id="cd-m" class="font-display text-2xl font-bold text-ink">00</span>
                        <span class="text-[10px] font-medium text-gray-400 mt-1">Menit</span>
                    </div>
                    <span class="text-xl font-bold text-gray-300">:</span>
                    <div class="w-20 h-20 rounded-2xl bg-white border border-gray-200 flex flex-col justify-center items-center shadow-sm relative overflow-hidden group/sec">
                        <div class="absolute inset-0 bg-orange-50/50 translate-y-full group-hover/sec:translate-y-0 transition-transform"></div>
                        <span id="cd-s" class="font-display text-2xl font-bold text-orange-600 relative z-10">00</span>
                        <span class="text-[10px] font-medium text-gray-400 mt-1 relative z-10">Detik</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('student.dashboard.home') }}" class="w-full sm:w-auto px-6 py-3.5 rounded-xl bg-ink text-white text-sm font-semibold hover:bg-ink/90 transition-colors shadow-sm flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Kembali ke Beranda
                </a>
                <a href="{{ route('scan.initial', $room->qr_token) }}" class="w-full sm:w-auto px-6 py-3.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-ink text-sm font-semibold transition-colors flex items-center justify-center gap-2">
                    Buka Halaman Ruangan
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        let remaining = {{ (int) $remainingSeconds }};

        const hEl = document.getElementById('cd-h');
        const mEl = document.getElementById('cd-m');
        const sEl = document.getElementById('cd-s');

        function pad(n) {
            return String(n).padStart(2, '0');
        }

        function render() {
            const hours = Math.floor(remaining / 3600);
            const minutes = Math.floor((remaining % 3600) / 60);
            const seconds = remaining % 60;

            hEl.textContent = pad(hours);
            mEl.textContent = pad(minutes);
            sEl.textContent = pad(seconds);
        }

        render();

        setInterval(function () {
            if (remaining > 0) {
                remaining--;
                render();
            }
        }, 1000);
    })();
</script>
@endsection

