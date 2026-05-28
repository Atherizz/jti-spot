@extends('layouts.dashboard')

@section('title', 'Jadwal Kelas')

@section('content')
    {{-- Editorial Page Header --}}
    <div class="mb-10 stagger-1">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-1.5 h-1.5 rounded-full bg-orange-500"></div>
            <span class="font-display font-semibold uppercase tracking-widest text-[11px] text-ink/50">Kurikulum Akademik</span>
        </div>
        <h1 class="font-display text-4xl font-bold tracking-tight text-ink mb-3 leading-tight">Agregasi Jadwal Kelas</h1>
        <p class="text-sm font-medium text-ink/60 max-w-xl leading-relaxed">
            Daftar sesi perkuliahan aktif untuk grup <span class="text-ink font-bold">{{ $classLabel }}</span>. Pantau alokasi ruang dan waktu secara *real-time*.
        </p>
    </div>

    {{-- Main Agenda --}}
    <div class="space-y-6 stagger-2">
        @forelse($groupedSchedules as $day)
        <div class="editorial-panel bg-white p-6 md:p-8 overflow-hidden relative">
            
            <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                <div class="flex items-center gap-3">
                    <h2 class="font-display text-xl font-bold text-ink">{{ $day['day'] }}</h2>
                </div>
                
                @if($day['is_today'])
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-widest bg-emerald-50 text-emerald-700 border border-emerald-100">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Hari Ini
                </span>
                @else
                <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest">{{ count($day['items']) }} Sesi</span>
                @endif
            </div>

            <div class="space-y-3">
                @foreach($day['items'] as $item)
                <div class="group border {{ $item['is_ongoing'] ? 'border-emerald-200 bg-emerald-50/30' : 'border-gray-100 bg-gray-50/50' }} rounded-xl p-4 sm:p-5 hover:border-gray-300 transition-colors">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="hidden sm:flex flex-col items-center justify-center w-12 h-12 rounded-lg {{ $item['is_ongoing'] ? 'bg-emerald-100 text-emerald-600' : 'bg-white border border-gray-200 text-gray-400' }} shadow-sm shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-display text-base font-bold text-ink leading-tight">{{ $item['course_name'] }}</p>
                                <div class="flex items-center gap-2 mt-1.5 text-[11px] font-semibold text-gray-500 uppercase tracking-widest">
                                    <span class="text-orange-600 bg-orange-50 px-2 py-0.5 rounded border border-orange-100">{{ $item['room_name'] }}</span>
                                </div>
                                @if($item['cancellation'])
                                <div class="mt-2 inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 border border-red-200 rounded-lg text-[11px] font-bold text-red-700">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    DIBATALKAN - {{ $item['cancellation']['date'] }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-col sm:items-end justify-center">
                            <div class="font-display text-lg font-bold {{ $item['is_ongoing'] ? 'text-emerald-700' : 'text-gray-900' }}">
                                {{ $item['time'] }}
                            </div>
                            @if($item['is_ongoing'])
                            <div class="text-[10px] uppercase font-bold tracking-widest text-emerald-600 mt-1">Sedang Berlangsung</div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- Reservasi ruangan untuk hari ini --}}
                @if(!empty($day['reservations']))
                    @foreach($day['reservations'] as $reservation)
                    <div class="group border border-orange-200 bg-orange-50/30 rounded-xl p-4 sm:p-5 hover:border-orange-300 transition-colors">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <div class="hidden sm:flex flex-col items-center justify-center w-12 h-12 rounded-lg bg-orange-100 text-orange-600 shadow-sm shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-display text-base font-bold text-ink leading-tight">Reservasi Ruangan</p>
                                    <div class="flex items-center gap-2 mt-1.5 text-[11px] font-semibold text-gray-500 uppercase tracking-widest">
                                        <span class="text-orange-600 bg-orange-50 px-2 py-0.5 rounded border border-orange-100">{{ $reservation['room_name'] }}</span>
                                    </div>
                                    <div class="mt-2 inline-flex items-center gap-1.5 px-2.5 py-1 bg-orange-100 border border-orange-200 rounded-lg text-[11px] font-bold text-orange-700">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        RUANGAN PENGGANTI - {{ $reservation['date'] }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col sm:items-end justify-center">
                                <div class="font-display text-lg font-bold text-orange-700">
                                    {{ $reservation['time'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
            
        </div>
        @empty
        <div class="editorial-panel bg-white p-10 text-center">
            <div class="w-16 h-16 bg-gray-50 border border-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm text-gray-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="font-display font-medium text-ink mb-1">Tidak Ada Jadwal</h3>
            <p class="text-xs font-medium text-gray-500 max-w-sm mx-auto">Kami belum menemukan alokasi jadwal terdaftar untuk afiliasi kelas Anda pada semester ini.</p>
        </div>
        @endforelse
    </div>
@endsection

