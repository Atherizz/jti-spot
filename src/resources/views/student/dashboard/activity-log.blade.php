@extends('layouts.dashboard')

@section('title', 'Aktivitas Crowdsourcing')

@section('content')

    {{-- Editorial Page Header --}}
    <div class="mb-8 stagger-1">
        <div class="flex items-center gap-4">
            <a href="{{ route('student.dashboard.home') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:text-ink hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm group">
                <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                    <span class="font-display text-[10px] font-semibold uppercase tracking-widest text-ink/50">Log Sistem Mahasiswa</span>
                </div>
                <h1 class="font-display text-2xl sm:text-3xl font-bold tracking-tight text-ink leading-tight">
                    Catatan Aktivitas Jaringan
                </h1>
            </div>
        </div>
    </div>

    {{-- Activities List in Formal Panel --}}
    <div class="editorial-panel bg-white overflow-hidden stagger-2 flex flex-col mb-10">
        
        {{-- Header Status --}}
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="font-display text-lg font-bold text-ink">Riwayat Interaksi Radar</h2>
                <p class="text-sm font-medium text-gray-500 mt-1">Daftar agregasi pencatatan data ke database institusi secara *real-time*.</p>
            </div>
            <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-lg">
                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-xs font-semibold text-gray-600">Sinkronisasi Aktif</span>
            </div>
        </div>

        <div class="p-6">
            <div class="relative">
                <!-- Formal timeline line -->
                @if(count($activities) > 0)
                <div class="absolute left-6 top-6 bottom-6 w-px bg-gray-100"></div>
                @endif
                
                <div class="space-y-6">
                    @forelse($activities as $activity)
                    <div class="flex items-start gap-5 relative z-10 group">
                        <div class="w-12 h-12 rounded-xl {{ $activity['type'] === 'QUORUM_REACHED' ? 'bg-emerald-50 border-emerald-100 text-emerald-600' : 'bg-gray-50 border-gray-200 text-gray-500' }} border flex items-center justify-center shrink-0 shadow-sm group-hover:scale-105 transition-transform bg-white">
                            @if($activity['type'] === 'QUORUM_REACHED')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 3.5a.5.5 0 11-1 0 .5.5 0 011 0z" />
                            </svg>
                            @endif
                        </div>
                        <div class="pt-2 pb-5 border-b border-gray-50 flex-1 min-w-0">
                            <p class="text-sm font-bold text-ink mb-1">{{ $activity['title'] }}</p>
                            <p class="text-xs font-medium text-gray-500 leading-relaxed">{{ $activity['subtitle'] }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="p-10 rounded-2xl border border-dashed border-gray-200 bg-gray-50/50 text-center">
                        <div class="w-16 h-16 bg-white border border-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm text-gray-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <h3 class="font-display font-medium text-ink mb-1">Log Kosong</h3>
                        <p class="text-xs font-medium text-gray-500 max-w-sm mx-auto">Kami belum menerima atau mencatat transmisi apa pun pada jaringan partisipasi Anda.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Formal Pagination Footer --}}
        @if($activities->hasPages())
        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex items-center justify-between">
            <div class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest hidden sm:block">
                Tampilan <span class="text-ink">{{ $activities->firstItem() }}</span> &mdash; <span class="text-ink">{{ $activities->lastItem() }}</span> dari <span class="text-ink">{{ $activities->total() }}</span> Entri
            </div>
            <nav class="flex items-center gap-1.5 w-full sm:w-auto justify-between sm:justify-end">
                {{-- Previous --}}
                @if($activities->onFirstPage())
                <button class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-300 cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </button>
                @else
                <a href="{{ $activities->previousPageUrl() }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-white hover:border-gray-200 border border-transparent transition-all shadow-none hover:shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </a>
                @endif

                {{-- Pages --}}
                <div class="flex items-center gap-1">
                    @php
                        $window = 2; 
                        $from = max($activities->currentPage() - $window, 1);
                        $to = min($activities->currentPage() + $window, $activities->lastPage());
                    @endphp

                    @if($from > 1)
                        <a href="{{ $activities->url(1) }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 text-xs font-medium transition-colors">1</a>
                        @if($from > 2)
                            <span class="px-1 text-gray-400">...</span>
                        @endif
                    @endif

                    @for($page = $from; $page <= $to; $page++)
                        @if($page == $activities->currentPage())
                            <button class="w-8 h-8 rounded-lg flex items-center justify-center bg-ink text-white shadow-sm text-xs font-bold">{{ $page }}</button>
                        @else
                            <a href="{{ $activities->url($page) }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 text-xs font-medium transition-colors">{{ $page }}</a>
                        @endif
                    @endfor

                    @if($to < $activities->lastPage())
                        @if($to < $activities->lastPage() - 1)
                            <span class="px-1 text-gray-400">...</span>
                        @endif
                        <a href="{{ $activities->url($activities->lastPage()) }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 text-xs font-medium transition-colors">{{ $activities->lastPage() }}</a>
                    @endif
                </div>

                {{-- Next --}}
                @if($activities->hasMorePages())
                <a href="{{ $activities->nextPageUrl() }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-white hover:border-gray-200 border border-transparent transition-all shadow-none hover:shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </a>
                @else
                <button class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-300 cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </button>
                @endif
            </nav>
        </div>
        @endif
    </div>

@endsection

