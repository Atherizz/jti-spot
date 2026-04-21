@extends('layouts.dashboard')

@section('title', 'Reservasi Ruangan')

@section('content')

    {{-- Editorial Page Header --}}
    <div class="mb-10 stagger-1">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 mb-4">
            <a href="{{ route('student.action.center') }}" class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-ink/40 uppercase tracking-widest hover:text-orange-600 transition-colors">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Pusat Aksi
            </a>
            <span class="text-ink/20 text-[11px]">/</span>
            <span class="text-[11px] font-semibold text-orange-600 uppercase tracking-widest">Reservasi Ruangan</span>
        </div>

        <div class="flex items-center gap-2 mb-2">
            <div class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></div>
            <span class="font-display font-semibold uppercase tracking-widest text-[11px] text-ink/50">Manajemen Ruangan</span>
        </div>
        <h1 class="font-display text-3xl sm:text-4xl font-bold tracking-tight text-ink mb-3 leading-tight">Reservasi Ruangan Kelas</h1>
        <p class="text-sm font-medium text-ink/60 max-w-xl leading-relaxed">
            Ajukan permintaan reservasi ruangan untuk jadwal kelas mendatang. Pengajuan berlaku untuk sesi <strong class="text-ink">H-1 atau H-2</strong> sebelum kelas dimulai.
        </p>
    </div>

    {{-- Formal Alert Panel --}}
    <div class="editorial-panel bg-orange-50/50 relative overflow-hidden mb-8 stagger-2 group">
        <div class="absolute -right-12 -top-12 w-48 h-48 bg-white/40 rounded-full blur-2xl pointer-events-none group-hover:bg-white/60 transition-colors"></div>
        <div class="p-6 relative z-10 flex gap-4">
            <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center shrink-0 shadow-[inset_0_1px_1px_rgba(255,255,255,0.5)] border border-orange-200 mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h3 class="font-display font-bold text-lg text-orange-900 mb-1 tracking-tight">Ketentuan Reservasi Ruangan</h3>
                <ul class="space-y-1">
                    <li class="text-sm font-medium text-orange-800/80 leading-relaxed flex items-start gap-2">
                        <svg class="w-3.5 h-3.5 mt-0.5 shrink-0 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        Reservasi hanya dapat diajukan untuk jadwal kelas <strong>1–2 hari ke depan</strong> (H-1 atau H-2).
                    </li>
                    <li class="text-sm font-medium text-orange-800/80 leading-relaxed flex items-start gap-2">
                        <svg class="w-3.5 h-3.5 mt-0.5 shrink-0 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        Status reservasi bersifat <strong>pending</strong> hingga divalidasi oleh sistem dan pihak administrasi.
                    </li>
                    <li class="text-sm font-medium text-orange-800/80 leading-relaxed flex items-start gap-2">
                        <svg class="w-3.5 h-3.5 mt-0.5 shrink-0 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        Pastikan ruangan yang direservasi sesuai dengan kapasitas kelas Anda.
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Reservation Form --}}
    <div class="editorial-panel bg-white overflow-hidden stagger-3">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center border border-orange-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <h2 class="font-display font-bold text-base text-ink tracking-tight">Formulir Pengajuan Reservasi</h2>
                <p class="text-[11px] font-semibold text-ink/40 uppercase tracking-widest">Lengkapi seluruh data di bawah ini</p>
            </div>
        </div>

        <div class="p-6 md:p-8">
            <form action="{{ route('student.action.reservasi.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-7">

                    {{-- Jadwal Kelas (Dropdown pilih jadwal yang akan direservasi) --}}
                    <div>
                        <label for="schedule_id" class="block text-[11px] font-semibold text-ink tracking-widest uppercase mb-2">
                            Jadwal Kelas yang Direservasi
                        </label>
                        <div class="relative">
                            <select id="schedule_id" name="schedule_id"
                                class="w-full appearance-none bg-white border border-gray-200 text-ink p-3.5 rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 hover:border-gray-300 transition-all shadow-sm">
                                <option disabled selected>-- Pilih jadwal yang akan direservasi --</option>
                                @foreach($upcomingSchedules ?? [] as $schedule)
                                    <option value="{{ $schedule->id }}" {{ old('schedule_id') == $schedule->id ? 'selected' : '' }}>
                                        {{ $schedule->course_name }} — {{ \Carbon\Carbon::parse($schedule->class_date)->translatedFormat('l, d M Y') }}
                                        ({{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>
                        @error('schedule_id')
                            <p class="mt-1.5 text-xs font-medium text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal Reservasi (dipilih, validasi H-1/H-2) --}}
                    <div>
                        <label for="reservation_date" class="block text-[11px] font-semibold text-ink tracking-widest uppercase mb-2">
                            Tanggal Pengajuan
                        </label>
                        <div class="relative">
                            <input type="date" id="reservation_date" name="reservation_date"
                                value="{{ old('reservation_date', now()->format('Y-m-d')) }}"
                                min="{{ now()->format('Y-m-d') }}"
                                class="w-full bg-white border border-gray-200 text-ink p-3.5 rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 hover:border-gray-300 transition-all shadow-sm">
                        </div>
                        @error('reservation_date')
                            <p class="mt-1.5 text-xs font-medium text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Pilihan Ruangan --}}
                    <div>
                        <label for="room_id" class="block text-[11px] font-semibold text-ink tracking-widest uppercase mb-2">
                            Ruangan yang Diminta
                        </label>
                        <div class="relative">
                            <select id="room_id" name="room_id"
                                class="w-full appearance-none bg-white border border-gray-200 text-ink p-3.5 rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 hover:border-gray-300 transition-all shadow-sm">
                                <option disabled selected>-- Pilih ruangan yang tersedia --</option>
                                @foreach($availableRooms ?? [] as $room)
                                    <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                        {{ $room->name }}
                                        @if($room->capacity) (Kapasitas: {{ $room->capacity }}) @endif
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>
                        @error('room_id')
                            <p class="mt-1.5 text-xs font-medium text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Waktu Mulai --}}
                    <div>
                        <label class="block text-[11px] font-semibold text-ink/40 tracking-widest uppercase mb-2">
                            Waktu Sesi Kelas
                        </label>
                        <div class="bg-gray-50 border border-gray-100 rounded-xl p-3.5 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-gray-400 shrink-0 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-sm font-medium text-gray-400" id="time-preview">Otomatis terisi saat jadwal dipilih</p>
                        </div>
                    </div>

                </div>

                {{-- Keterangan / Justifikasi --}}
                <div class="mt-8 border-t border-gray-100 pt-8">
                    <label for="notes" class="block text-[11px] font-semibold text-ink tracking-widest uppercase mb-2">
                        Keterangan Pengajuan
                        <span class="normal-case tracking-normal text-ink/40 ml-1">(Opsional)</span>
                    </label>
                    <textarea id="notes" name="notes" rows="3"
                        placeholder="Jelaskan alasan atau kebutuhan khusus terkait reservasi ruangan ini..."
                        class="w-full bg-white border border-gray-200 text-ink p-4 rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 hover:border-gray-300 transition-all shadow-sm resize-none placeholder:text-gray-400">{{ old('notes') }}</textarea>
                </div>

                {{-- Priority Window Info --}}
                <div class="mt-6 bg-gray-50/80 border border-gray-100 rounded-xl p-4 flex items-center gap-3">
                    <div class="w-7 h-7 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-400 shrink-0 shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-[12px] font-medium text-ink/50 leading-relaxed">
                        Reservasi yang diajukan di luar jendela waktu H-1 / H-2 akan <strong class="text-ink/70">otomatis ditolak</strong> oleh sistem. Pastikan tanggal jadwal yang dipilih sesuai.
                    </p>
                </div>

                {{-- Submit Dock --}}
                <div class="mt-10 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 pt-4">
                    <a href="{{ route('student.action.center') }}"
                        class="w-full sm:w-auto px-6 py-3 rounded-xl border border-gray-200 bg-white text-ink font-semibold hover:bg-gray-50 transition-colors shadow-sm text-sm text-center">
                        Batalkan
                    </a>
                    <button type="submit"
                        class="w-full sm:w-auto px-8 py-3 rounded-xl bg-orange-600 text-white font-semibold hover:bg-orange-700 active:scale-95 transition-all flex items-center justify-center gap-2 text-sm group shadow-md shadow-orange-600/20 border border-orange-500">
                        <svg class="w-4 h-4 group-hover:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Kirim Permohonan Reservasi
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Update time preview saat jadwal dipilih
    document.getElementById('schedule_id').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const text = selected.text;
        const timeMatch = text.match(/\(([^)]+)\)/);
        const preview = document.getElementById('time-preview');
        if (timeMatch) {
            preview.textContent = timeMatch[1];
            preview.classList.remove('text-gray-400');
            preview.classList.add('text-ink');
        } else {
            preview.textContent = 'Otomatis terisi saat jadwal dipilih';
            preview.classList.add('text-gray-400');
            preview.classList.remove('text-ink');
        }
    });
</script>
@endpush
