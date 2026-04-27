@extends('layouts.dashboard')

@section('title', 'Pembatalan Kelas')

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
            <span class="text-[11px] font-semibold text-red-600 uppercase tracking-widest">Pembatalan Kelas</span>
        </div>

        <div class="flex items-center gap-2 mb-2">
            <div class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></div>
            <span class="font-display font-semibold uppercase tracking-widest text-[11px] text-ink/50">Manajemen Jadwal</span>
        </div>
        <h1 class="font-display text-3xl sm:text-4xl font-bold tracking-tight text-ink mb-3 leading-tight">Pembatalan Jadwal Kelas</h1>
        <p class="text-sm font-medium text-ink/60 max-w-xl leading-relaxed">
            Ajukan permohonan pembatalan sesi kelas yang terdaftar. Setiap pengajuan memerlukan justifikasi yang valid dan akan diproses oleh pihak akademik.
        </p>
    </div>

    {{-- Warning Alert Panel --}}
    <div class="editorial-panel bg-red-50/50 border border-red-100/80 relative overflow-hidden mb-8 stagger-2 group">
        <div class="absolute -right-12 -top-12 w-48 h-48 bg-white/40 rounded-full blur-2xl pointer-events-none group-hover:bg-white/60 transition-colors"></div>
        <div class="p-6 relative z-10 flex gap-4">
            <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0 shadow-[inset_0_1px_1px_rgba(255,255,255,0.5)] border border-red-200 mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div>
                <h3 class="font-display font-bold text-lg text-red-900 mb-1 tracking-tight">Perhatian — Tindakan Tidak Dapat Dibatalkan</h3>
                <ul class="space-y-1">
                    <li class="text-sm font-medium text-red-800/80 leading-relaxed flex items-start gap-2">
                        <svg class="w-3.5 h-3.5 mt-0.5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        Pengajuan pembatalan harus diajukan <strong>minimal 24 jam</strong> sebelum jadwal kelas dimulai.
                    </li>
                    <li class="text-sm font-medium text-red-800/80 leading-relaxed flex items-start gap-2">
                        <svg class="w-3.5 h-3.5 mt-0.5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        Permohonan yang telah dikirim <strong>tidak dapat ditarik kembali</strong> secara mandiri — hubungi admin jika terjadi kesalahan.
                    </li>
                    <li class="text-sm font-medium text-red-800/80 leading-relaxed flex items-start gap-2">
                        <svg class="w-3.5 h-3.5 mt-0.5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        Pembatalan yang tidak berdasar dapat mempengaruhi rekam jejak akademik Anda.
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Cancellation Form --}}
    <div class="editorial-panel bg-white overflow-hidden stagger-3">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-red-50 text-red-500 flex items-center justify-center border border-red-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
            </div>
            <div>
                <h2 class="font-display font-bold text-base text-ink tracking-tight">Formulir Pembatalan Kelas</h2>
                <p class="text-[11px] font-semibold text-ink/40 uppercase tracking-widest">Isi data pembatalan dengan benar</p>
            </div>
        </div>

        <div class="p-6 md:p-8">
            <form action="{{ route('student.action.pembatalan.store') }}" method="POST" id="cancellationForm">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-7">

                    {{-- Jadwal yang akan dibatalkan --}}
                    <div class="md:col-span-2">
                        <label for="schedule_data" class="block text-[11px] font-semibold text-ink tracking-widest uppercase mb-2">
                            Jadwal Kelas yang Dibatalkan
                        </label>
                        <div class="relative">
                            <select id="schedule_data" name="schedule_data" required
                                class="w-full appearance-none bg-white border border-gray-200 text-ink p-3.5 rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 hover:border-gray-300 transition-all shadow-sm">
                                @if(isset($cancelableSchedules) && $cancelableSchedules->count() > 0)
                                    <option value="" disabled selected>-- Pilih jadwal yang akan dibatalkan --</option>
                                    @foreach($cancelableSchedules as $schedule)
                                        <option value="{{ $schedule->cancel_id }}" {{ old('schedule_data') == $schedule->cancel_id ? 'selected' : '' }}
                                            data-date="{{ \Carbon\Carbon::parse($schedule->class_date)->translatedFormat('l, d M Y') }}"
                                            data-time="{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}"
                                            data-room="{{ $schedule->room->name ?? '-' }}">
                                            {{ $schedule->course_name }} — {{ \Carbon\Carbon::parse($schedule->class_date)->translatedFormat('l, d M Y') }}
                                            ({{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }})
                                        </option>
                                    @endforeach
                                @else
                                    <option disabled selected>-- Tidak ada jadwal kelas yang tersedia --</option>
                                @endif
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>
                        @error('schedule_data')
                            <p class="mt-1.5 text-xs font-medium text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Schedule Detail Preview --}}
                    <div id="schedule-preview" class="md:col-span-2 hidden">
                        <div class="bg-gray-50/80 border border-gray-100 rounded-xl p-5 grid grid-cols-3 gap-4">
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-ink/40 mb-1">Tanggal</p>
                                <p class="font-semibold text-ink text-sm" id="preview-date">—</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-ink/40 mb-1">Waktu</p>
                                <p class="font-semibold text-ink text-sm" id="preview-time">—</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-ink/40 mb-1">Ruangan</p>
                                <p class="font-semibold text-ink text-sm" id="preview-room">—</p>
                            </div>
                        </div>
                    </div>

                    {{-- Tanggal Operasi (readonly/system) --}}
                    <div>
                        <label class="block text-[11px] font-semibold text-ink/40 tracking-widest uppercase mb-2">
                            Tanggal Pengajuan (Sistem)
                        </label>
                        <div class="relative">
                            <input type="text" value="{{ now()->translatedFormat('l, d F Y') }}" readonly
                                class="w-full bg-gray-50 border border-gray-100 text-gray-400 p-3.5 rounded-xl text-sm font-medium focus:outline-none cursor-not-allowed">
                        </div>
                        <input type="hidden" name="request_date" value="{{ now()->format('Y-m-d') }}">
                    </div>

                    {{-- Kategori Pembatalan --}}
                    <div>
                        <label for="cancellation_type" class="block text-[11px] font-semibold text-ink tracking-widest uppercase mb-2">
                            Kategori Pembatalan
                        </label>
                        <div class="relative">
                            <select id="cancellation_type" name="cancellation_type" required
                                class="w-full appearance-none bg-white border border-gray-200 text-ink p-3.5 rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 hover:border-gray-300 transition-all shadow-sm">
                                <option value="" disabled selected>-- Pilih kategori --</option>
                                <option value="sakit" {{ old('cancellation_type') === 'sakit' ? 'selected' : '' }}>Dosen Sakit / Kondisi Medis</option>
                                <option value="kegiatan_kampus" {{ old('cancellation_type') === 'kegiatan_kampus' ? 'selected' : '' }}>Kegiatan Resmi Kampus</option>
                                <option value="musibah" {{ old('cancellation_type') === 'musibah' ? 'selected' : '' }}>Musibah</option>
                                <option value="lainnya" {{ old('cancellation_type') === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>
                        @error('cancellation_type')
                            <p class="mt-1.5 text-xs font-medium text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Justifikasi Pembatalan (Wajib) --}}
                <div class="mt-8 border-t border-gray-100 pt-8">
                    <label for="reason" class="block text-[11px] font-semibold text-ink tracking-widest uppercase mb-2">
                        Justifikasi Pembatalan
                        <span class="normal-case tracking-normal text-red-500 ml-1">*Wajib</span>
                    </label>
                    <textarea id="reason" name="reason" rows="4" required
                        placeholder="Deskripsikan secara rinci alasan pembatalan kelas ini. Sertakan bukti pendukung apabila tersedia (nomor surat, kode kegiatan, dsb)..."
                        class="w-full bg-white border border-gray-200 text-ink p-4 rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 hover:border-gray-300 transition-all shadow-sm resize-none placeholder:text-gray-400">{{ old('reason') }}</textarea>
                    @error('reason')
                        <p class="mt-1.5 text-xs font-medium text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirmation Checkbox --}}
                <div class="mt-6 bg-red-50/60 border border-red-100 rounded-xl p-4">
                    <label for="confirm_cancellation" class="flex items-start gap-3 cursor-pointer group">
                        <input type="checkbox" id="confirm_cancellation" name="confirm_cancellation" value="1" required
                            class="mt-0.5 w-4 h-4 rounded border-red-300 text-red-600 focus:ring-red-500 shrink-0">
                        <span class="text-sm font-medium text-red-800/80 leading-relaxed">
                            Saya memahami bahwa pengajuan ini <strong>bersifat final</strong> dan tidak dapat dibatalkan secara mandiri. Data pengajuan ini akan tercatat dalam sistem dan diverifikasi oleh pihak akademik.
                        </span>
                    </label>
                </div>

                {{-- Submit Dock --}}
                <div class="mt-10 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 pt-4">
                    <a href="{{ route('student.action.center') }}"
                        class="w-full sm:w-auto px-6 py-3 rounded-xl border border-gray-200 bg-white text-ink font-semibold hover:bg-gray-50 transition-colors shadow-sm text-sm text-center">
                        Batalkan
                    </a>
                    <button type="submit" id="submitBtn"
                        class="w-full sm:w-auto px-8 py-3 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-700 active:scale-95 transition-all flex items-center justify-center gap-2 text-sm group shadow-md shadow-red-600/20 border border-red-500 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-4 h-4 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                        Kirim Permohonan Pembatalan
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Show schedule detail preview when a schedule is selected
    const scheduleSelect = document.getElementById('schedule_data');
    const schedulePreview = document.getElementById('schedule-preview');

    scheduleSelect.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        if (selected.value) {
            document.getElementById('preview-date').textContent = selected.dataset.date ?? '—';
            document.getElementById('preview-time').textContent = selected.dataset.time ?? '—';
            document.getElementById('preview-room').textContent = selected.dataset.room ?? '—';
            schedulePreview.classList.remove('hidden');
        } else {
            schedulePreview.classList.add('hidden');
        }
    });

    // Trigger preview if old value is set (validation error case)
    if (scheduleSelect.value) {
        scheduleSelect.dispatchEvent(new Event('change'));
    }
</script>
@endpush
