@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="mb-10 pb-8 stagger-1 relative pt-4 border-b border-gray-100">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 relative z-10">
            <div class="max-w-2xl text-ink">
                <div class="flex items-center gap-3 mb-3">
                    <a href="{{ route('student.action.center') }}" class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:text-ink hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <span class="font-display font-semibold uppercase tracking-widest text-[11px] text-ink/50">Riwayat Pusat Aksi</span>
                </div>
                <h1 class="font-display text-4xl md:text-5xl font-bold tracking-tight leading-tight mb-3">
                    Aktivitas Kelas
                </h1>
                <p class="text-base font-medium max-w-lg mt-3 text-ink/60">
                    Daftar seluruh pengajuan reservasi ruangan dan pembatalan jadwal untuk kelas Anda.
                </p>
            </div>
            
            <div class="editorial-panel bg-white px-6 py-4 flex flex-col justify-center items-center text-center self-start md:self-end">
                <span class="block text-[10px] font-semibold uppercase tracking-widest text-ink/40 mb-1">Total Pengajuan</span>
                <span class="font-display text-2xl font-bold text-ink">{{ $allRequests->count() }}</span>
            </div>
        </div>
    </div>

    <!-- History List -->
    <div class="stagger-2">
        <div class="editorial-panel bg-white p-6 md:p-8">
            <h3 class="font-display font-bold text-lg mb-6">Riwayat Lengkap</h3>

            @if($allRequests->isEmpty())
                <div class="text-center py-12 px-4 border-2 border-dashed border-gray-100 rounded-2xl bg-gray-50/50">
                    <div class="w-16 h-16 rounded-full bg-white border border-gray-100 flex items-center justify-center mx-auto mb-4 shadow-sm">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="font-display text-lg font-bold text-ink mb-2">Belum Ada Aktivitas</h3>
                    <p class="text-sm font-medium text-gray-500 max-w-md mx-auto">
                        Belum ada pengajuan pembatalan jadwal kelas dari perwakilan kelas Anda.
                    </p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($allRequests as $req)
                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 p-5 rounded-2xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all bg-white group">
                            
                            <!-- Info Utama -->
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 shrink-0 rounded-xl flex items-center justify-center border
                                    {{ $req['type'] === 'Pembatalan Kelas' ? 'bg-red-50 border-red-100 text-red-500' : 'bg-orange-50 border-orange-100 text-orange-500' }}">
                                    @if($req['type'] === 'Pembatalan Kelas')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    @else
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    @endif
                                </div>
                                
                                <div>
                                    <div class="flex items-center gap-2 mb-1.5">
                                        <span class="text-[10px] font-bold tracking-wider uppercase {{ $req['type'] === 'Pembatalan Kelas' ? 'text-red-500' : 'text-orange-500' }}">
                                            {{ $req['type'] }}
                                        </span>
                                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                        <span class="text-[11px] font-medium text-gray-400">Diajukan: {{ $req['date'] }}</span>
                                    </div>
                                    <h4 class="font-display font-bold text-ink text-base">{{ $req['title'] }}</h4>
                                    <p class="text-sm font-medium text-gray-500 mt-1 line-clamp-1">
                                        Target Tanggal: <strong class="text-ink">{{ $req['target'] }}</strong> &bull; Oleh: {{ $req['by'] }}
                                    </p>
                                    @if(!empty($req['reason']))
                                        <details class="mt-2 group/details">
                                            <summary class="cursor-pointer text-[11px] font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-1 hover:text-gray-600 transition-colors focus:outline-none select-none list-none [&::-webkit-details-marker]:hidden">
                                                <svg class="w-3 h-3 transition-transform duration-200 group-open/details:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                                <span class="group-open/details:hidden">Lihat Alasan</span>
                                                <span class="hidden group-open/details:inline">Tutup Alasan</span>
                                            </summary>
                                            <div class="mt-3 p-3 rounded-xl bg-gray-50 border border-gray-100 text-sm text-gray-600 italic leading-relaxed shadow-[inset_0_1px_2px_rgba(0,0,0,0.02)] animate-[fade-in_0.2s_ease-out]">
                                                "{{ $req['reason'] }}"
                                            </div>
                                        </details>
                                    @endif
                                </div>
                            </div>
                            
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
