@extends('layouts.dashboard')

@section('title', 'Check-in Berhasil')

@section('content')
<div class="flex items-center justify-center min-h-[calc(100vh-220px)]">
    <div class="w-full max-w-3xl bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sm:p-8">
        <div class="flex flex-col items-center text-center mb-8">
            <div class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Check-in Berhasil!</h1>
            <p class="text-sm text-gray-500 mt-2">Kontribusi Anda membantu validasi kuorum ruangan.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-gray-50 border border-gray-100 rounded-xl p-4 sm:p-5">
            <div>
                <p class="text-xs text-gray-400">Room</p>
                <p class="text-base font-semibold text-gray-900 mt-1">{{ $room->name }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Mata Kuliah</p>
                <p class="text-base font-semibold text-gray-900 mt-1">{{ $subjectName }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Kelas</p>
                <p class="text-base font-semibold text-gray-900 mt-1">{{ $className }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Status</p>
                <p class="text-base font-semibold text-emerald-600 mt-1">Hadir</p>
            </div>
            <div class="sm:col-span-2">
                <p class="text-xs text-gray-400">Waktu Check-in</p>
                <p class="text-base font-semibold text-gray-900 mt-1">
                    {{ $checkedInAt ? \Carbon\Carbon::parse($checkedInAt)->format('d M Y, H:i:s') : '-' }}
                </p>
            </div>
        </div>

        <div class="mt-8 text-center">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-3">Time Remaining</p>
            <div id="countdown" class="flex items-center justify-center gap-3 text-gray-900">
                <div class="w-16 h-16 rounded-xl bg-gray-50 border border-gray-200 flex flex-col justify-center">
                    <span id="cd-h" class="text-xl font-bold">00</span>
                    <span class="text-[10px] uppercase text-gray-400">Hours</span>
                </div>
                <div class="w-16 h-16 rounded-xl bg-gray-50 border border-gray-200 flex flex-col justify-center">
                    <span id="cd-m" class="text-xl font-bold">00</span>
                    <span class="text-[10px] uppercase text-gray-400">Minutes</span>
                </div>
                <div class="w-16 h-16 rounded-xl bg-gray-50 border border-gray-200 flex flex-col justify-center">
                    <span id="cd-s" class="text-xl font-bold">00</span>
                    <span class="text-[10px] uppercase text-gray-400">Seconds</span>
                </div>
            </div>
        </div>

        <div class="mt-8 flex items-center justify-center gap-3">
            <a href="{{ route('student.dashboard.home') }}" class="px-5 py-2.5 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold transition-colors">
                Kembali ke Beranda
            </a>
            <a href="{{ route('scan.initial', $room->qr_token) }}" class="px-5 py-2.5 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-sm font-semibold transition-colors">
                Buka Ruangan
            </a>
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
