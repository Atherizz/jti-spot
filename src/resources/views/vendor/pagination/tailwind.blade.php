@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">

        {{-- Mobile View --}}
        <div class="flex gap-2 items-center justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-4 py-2 text-sm font-bold tracking-widest uppercase text-gray-400 bg-gray-50 border border-gray-200 cursor-not-allowed rounded-xl shadow-sm">
                    {!! __('Prev') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-4 py-2 text-sm font-bold tracking-widest uppercase text-ink bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                    {!! __('Prev') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-4 py-2 text-sm font-bold tracking-widest uppercase text-ink bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                    {!! __('Next') !!}
                </a>
            @else
                <span class="inline-flex items-center px-4 py-2 text-sm font-bold tracking-widest uppercase text-gray-400 bg-gray-50 border border-gray-200 cursor-not-allowed rounded-xl shadow-sm">
                    {!! __('Next') !!}
                </span>
            @endif
        </div>

        {{-- Desktop View --}}
        <div class="hidden sm:flex-1 sm:flex sm:gap-4 sm:items-center sm:justify-between border-t border-gray-100 pt-5">
            <div>
                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest">
                    {!! __('Tampilan Data') !!}
                    @if ($paginator->firstItem())
                        <span class="font-bold text-ink">{{ $paginator->firstItem() }}</span>
                        &mdash;
                        <span class="font-bold text-ink">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    / 
                    <span class="font-bold text-ink">{{ $paginator->total() }}</span>
                    {!! __('Entri') !!}
                </p>
            </div>

            <div class="flex items-center gap-1.5">
                {{-- Prev Button --}}
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-300 cursor-not-allowed" aria-hidden="true">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                        </span>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="w-8 h-8 rounded-lg flex items-center justify-center text-ink hover:bg-white border border-transparent hover:border-gray-200 transition-all shadow-none hover:shadow-sm" aria-label="{{ __('pagination.previous') }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($elements as $element)
                    {{-- "..." Separator --}}
                    @if (is_string($element))
                        <span aria-disabled="true">
                            <span class="px-1 text-gray-400 font-bold tracking-widest cursor-default">{{ $element }}</span>
                        </span>
                    @endif

                    {{-- Page Array --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page">
                                    <span class="w-8 h-8 rounded-lg flex items-center justify-center bg-ink text-white shadow-sm text-xs font-bold cursor-default">{{ $page }}</span>
                                </span>
                            @else
                                <a href="{{ $url }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-white hover:border-gray-200 text-xs font-bold transition-all border border-transparent shadow-none hover:shadow-sm" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Button --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="w-8 h-8 rounded-lg flex items-center justify-center text-ink hover:bg-white border border-transparent hover:border-gray-200 transition-all shadow-none hover:shadow-sm" aria-label="{{ __('pagination.next') }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                @else
                    <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-300 cursor-not-allowed" aria-hidden="true">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </span>
                    </span>
                @endif
            </div>
        </div>
    </nav>
@endif
