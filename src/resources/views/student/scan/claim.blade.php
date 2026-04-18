@extends('layouts.dashboard')

@section('title', 'Klaim Ruangan')

@section('content')

    {{-- Editorial Page Header --}}
    <div class="mb-10 stagger-1">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></div>
            <span class="font-display font-semibold uppercase tracking-widest text-[11px] text-ink/50">Prosedur Pengambilalihan</span>
        </div>
        <h1 class="font-display text-3xl sm:text-4xl font-bold tracking-tight text-ink mb-3 leading-tight">Resolusi Konflik Kelas</h1>
        <p class="text-sm font-medium text-ink/60 max-w-xl leading-relaxed">
            Sistem mendeteksi bahwa ruangan digunakan tidak sesuai dengan jadwal. Silakan inisiasi proses klaim untuk memprioritaskan jadwal Anda.
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
                <h3 class="font-display font-bold text-lg text-orange-900 mb-1 tracking-tight">Regulasi Kuorum Validasi</h3>
                <p class="text-sm font-medium text-orange-800/80 leading-relaxed">
                    Pengajuan klaim ini bersifat *pending* hingga sejumlah titik validasi geografis mahasiswa kelas Anda terpenuhi di lokasi. Instruksikan anggota kelas untuk memindai kode QR.
                </p>
            </div>
        </div>
    </div>

    {{-- Form Data --}}
    <div class="editorial-panel bg-white overflow-hidden stagger-3">
        <div class="p-6 md:p-8">
            <form action="{{ route('scan.claim', $qrToken) }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    
                    {{-- Target Schedule (Disabled) --}}
                    <div>
                        <label class="block text-[11px] font-semibold text-ink/40 tracking-widest uppercase mb-2">Jadwal Tumpang Tindih (Sistem)</label>
                        <div class="relative">
                            <select class="w-full appearance-none bg-gray-50 border border-gray-100 text-gray-400 p-3.5 rounded-xl text-sm font-medium focus:outline-none pointer-events-none cursor-not-allowed" disabled>
                                @if($claimedSchedule)
                                    <option selected>
                                        {{ $claimedSchedule->course_name }} ({{ \Carbon\Carbon::parse($claimedSchedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($claimedSchedule->end_time)->format('H:i') }})
                                    </option>
                                @else
                                    <option selected>Tidak ada jadwal terdaftar saat ini</option>
                                @endif
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>
                        @if($claimedSchedule)
                            <input type="hidden" name="claimed_schedule_id" value="{{ $claimedSchedule->id }}">
                        @endif
                    </div>

                    {{-- Original Schedule (Editable dropdown) --}}
                    <div>
                        <label class="block text-[11px] font-semibold text-ink tracking-widest uppercase mb-2">Jadwal Prioritas Anda (Pengganti)</label>
                        <div class="relative">
                            <select name="original_schedule_id" class="w-full appearance-none bg-white border border-gray-200 text-ink p-3.5 rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 hover:border-gray-300 transition-all shadow-sm">
                                <option disabled selected>-- Pilih jadwal kelas substitusi --</option>
                                @foreach($originalSchedules as $schedule)
                                    <option value="{{ $schedule->id }}">
                                        {{ $schedule->course_name }} ({{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Room Selection (Disabled) --}}
                    <div>
                        <label class="block text-[11px] font-semibold text-ink/40 tracking-widest uppercase mb-2">Lokasi Terikat</label>
                        <div class="relative">
                            <select class="w-full appearance-none bg-gray-50 border border-gray-100 text-gray-400 p-3.5 rounded-xl text-sm font-medium focus:outline-none pointer-events-none cursor-not-allowed" disabled>
                                <option selected>{{ $room->name ?? 'Ruangan Indefinit' }}</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Claim Date (Disabled) --}}
                    <div>
                        <label class="block text-[11px] font-semibold text-ink/40 tracking-widest uppercase mb-2">Tanggal Operasi</label>
                        <div class="relative">
                            <input type="text" value="{{ \Carbon\Carbon::parse($claimedDate)->format('d F Y') }}" readonly class="w-full bg-gray-50 border border-gray-100 text-gray-400 p-3.5 rounded-xl text-sm font-medium focus:outline-none cursor-not-allowed">
                        </div>
                    </div>
                </div>

                {{-- Reason for Claim --}}
                <div class="mt-8 border-t border-gray-100 pt-8">
                    <label class="block text-[11px] font-semibold text-ink tracking-widest uppercase mb-2">Dokumentasi Justifikasi (Opsional)</label>
                    <textarea name="reason" rows="3" placeholder="Deskripsikan alasan atau bukti kuat atas klaim prioritas blok ruangan ini..." class="w-full bg-white border border-gray-200 text-ink p-4 rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 hover:border-gray-300 transition-all shadow-sm resize-none placeholder:text-gray-400"></textarea>
                </div>

                {{-- Submit Dock --}}
                <div class="mt-10 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 pt-4">
                    <a href="{{ route('student.dashboard.home') }}" class="w-full sm:w-auto px-6 py-3 rounded-xl border border-gray-200 bg-white text-ink font-semibold hover:bg-gray-50 transition-colors shadow-sm text-sm text-center">
                        Batalkan Instruksi
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-8 py-3 rounded-xl bg-orange-600 text-white font-semibold hover:bg-orange-700 transition-colors flex items-center justify-center gap-2 text-sm group shadow-md shadow-orange-600/20 border border-orange-500">
                        <svg class="w-4 h-4 group-hover:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Inisiasi Klaim
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
