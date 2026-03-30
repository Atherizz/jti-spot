@extends('layouts.dashboard')

@section('title', 'Aktivitas Crowdsourcing')

@section('content')

    {{-- Page Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-4">
            <a href="{{ route('student.dashboard.home') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white border border-gray-200 hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-indigo-900">Aktivitas Crowdsourcing</h1>
                <p class="text-sm text-gray-500 mt-1">Riwayat lengkap aktivitas verifikasi kehadiran kelas Anda</p>
            </div>
        </div>
    </div>

    {{-- Activities List --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 sm:p-6">
            <div class="space-y-3">
                @forelse($activities as $activity)
                <div class="flex items-start gap-3 p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                    <div class="w-10 h-10 rounded-xl {{ $activity['type'] === 'QUORUM_REACHED' ? 'bg-emerald-50 border border-emerald-100' : 'bg-white border border-gray-200' }} flex items-center justify-center shrink-0 shadow-sm">
                        @if($activity['type'] === 'QUORUM_REACHED')
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        @else
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 3.5a.5.5 0 11-1 0 .5.5 0 011 0z" />
                        </svg>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-800">{{ $activity['title'] }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $activity['subtitle'] }}</p>
                    </div>
                </div>
                @empty
                <div class="p-4 rounded-xl bg-gray-50 text-center">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p class="text-gray-500 text-sm">Belum ada aktivitas untuk kelas Anda</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Pagination --}}
        @if($activities->hasPages())
        <div class="px-5 sm:px-6 py-4 bg-gray-50 border-t border-gray-100">
            <div class="flex items-center justify-between">
                <div class="text-xs text-gray-500">
                    Menampilkan <span class="font-medium">{{ $activities->firstItem() }}</span> hingga <span class="font-medium">{{ $activities->lastItem() }}</span> dari <span class="font-medium">{{ $activities->total() }}</span> aktivitas
                </div>
                <nav class="flex items-center gap-2">
                    {{-- Previous Page --}}
                    @if($activities->onFirstPage())
                    <button class="p-2 rounded-lg text-gray-400 cursor-not-allowed opacity-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    @else
                    <a href="{{ $activities->previousPageUrl() }}" class="p-2 rounded-lg text-gray-600 hover:bg-white border border-gray-200 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    @endif

                    {{-- Page Numbers --}}
                    @php
                        $window = 2; // Number of pages to show on each side of current page
                        $from = max($activities->currentPage() - $window, 1);
                        $to = min($activities->currentPage() + $window, $activities->lastPage());
                    @endphp

                    @if($from > 1)
                        <a href="{{ $activities->url(1) }}" class="px-3 py-1 rounded-lg text-gray-600 hover:bg-white border border-gray-200 text-sm transition-colors">1</a>
                        @if($from > 2)
                            <span class="px-2 text-gray-400">...</span>
                        @endif
                    @endif

                    @for($page = $from; $page <= $to; $page++)
                        @if($page == $activities->currentPage())
                            <button class="px-3 py-1 rounded-lg bg-indigo-600 text-white text-sm font-medium">{{ $page }}</button>
                        @else
                            <a href="{{ $activities->url($page) }}" class="px-3 py-1 rounded-lg text-gray-600 hover:bg-white border border-gray-200 text-sm transition-colors">{{ $page }}</a>
                        @endif
                    @endfor

                    @if($to < $activities->lastPage())
                        @if($to < $activities->lastPage() - 1)
                            <span class="px-2 text-gray-400">...</span>
                        @endif
                        <a href="{{ $activities->url($activities->lastPage()) }}" class="px-3 py-1 rounded-lg text-gray-600 hover:bg-white border border-gray-200 text-sm transition-colors">{{ $activities->lastPage() }}</a>
                    @endif

                    {{-- Next Page --}}
                    @if($activities->hasMorePages())
                    <a href="{{ $activities->nextPageUrl() }}" class="p-2 rounded-lg text-gray-600 hover:bg-white border border-gray-200 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    @else
                    <button class="p-2 rounded-lg text-gray-400 cursor-not-allowed opacity-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    @endif
                </nav>
            </div>
        </div>
        @endif
    </div>

@endsection
