@extends('layouts.app')

@section('content')
    <div class="mb-10 pb-8 stagger-1 relative pt-4">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 relative z-10">
            <div class="max-w-2xl text-ink">
                <div class="flex items-center gap-2 mb-3">
                    <span class="font-display font-semibold uppercase tracking-widest text-[11px] text-ink/50">Navigasi Visual</span>
                </div>
                <h1 class="font-display text-4xl md:text-5xl font-bold tracking-tight leading-tight mb-3">
                    Peta Ruang Kampus
                </h1>
                <p class="text-base font-medium max-w-lg mt-3 text-ink/60">
                    Lihat status ruang secara visual berdasarkan lantai. Klik opsi lantai untuk fokus pada area tertentu.
                </p>
            </div>
            <a href="/" class="editorial-panel bg-white px-6 py-4 flex flex-col justify-center items-center text-center self-start md:self-end hover:bg-gray-50 transition-colors group">
                <span class="block text-[10px] font-semibold uppercase tracking-widest text-ink/40 mb-1">Aksi Cepat</span>
                <span class="font-display text-sm font-bold text-ink inline-flex items-center gap-2">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Kembali ke Beranda
                </span>
            </a>
        </div>
        <div class="absolute left-0 top-0 w-64 h-64 bg-emerald-50 rounded-full blur-3xl -translate-x-1/4 -translate-y-1/4 pointer-events-none z-0"></div>
    </div>

    <div class="bg-white border rounded-2xl border-gray-100 shadow-sm p-3 mb-8 flex flex-col md:flex-row justify-between items-center gap-4 stagger-2">
        @php
            $currentFloor = request('floor');
        @endphp
        
        <div class="flex items-center gap-1.5 bg-gray-50/50 p-1.5 rounded-xl border border-gray-100 w-full md:w-auto overflow-x-auto">
            <a href="{{ request()->fullUrlWithQuery(['floor' => null, 'page' => null]) }}" 
                class="px-4 py-2 font-medium text-xs rounded-lg transition-all flex items-center gap-2 {{ is_null($currentFloor) ? 'bg-white text-ink shadow-sm ring-1 ring-gray-200' : 'text-gray-500 hover:text-ink' }}">
                <svg class="w-4 h-4 {{ is_null($currentFloor) ? 'text-orange-600' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                </svg>
                Semua Lantai
            </a>
            
            @foreach([5, 6, 7, 8] as $floor)
                <a href="{{ request()->fullUrlWithQuery(['floor' => $floor, 'page' => null]) }}" 
                    class="px-4 py-2 font-medium text-xs rounded-lg transition-all {{ $currentFloor == $floor ? 'bg-white text-ink shadow-sm ring-1 ring-gray-200' : 'text-gray-500 hover:text-ink' }}">
                    Lantai {{ $floor }}
                </a>
            @endforeach
        </div>

        <form method="GET" action="{{ url()->current() }}" class="w-full md:w-auto relative group">
            @if(request('floor'))
                <input type="hidden" name="floor" value="{{ request('floor') }}">
            @endif
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ruang (mis. LSI-1)" class="w-full sm:w-64 pl-9 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl font-medium placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-300 text-sm transition-all shadow-sm">
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 stagger-3 mb-10">
        
        <div class="md:col-span-5 editorial-panel bg-white p-6 flex flex-col h-[500px]">
            <h2 class="font-display text-xl font-bold text-ink mb-6">Daftar Indeks</h2>
            <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar flex flex-col gap-3">
                @foreach($rooms as $room)
                    @php
                        $statusColors = ['available' => 'bg-emerald-50 text-emerald-700 ring-emerald-200', 'waiting' => 'bg-orange-50 text-orange-700 ring-orange-200', 'occupied' => 'bg-red-50 text-red-700 ring-red-200'];
                        $badgeClass = $statusColors[$room->current_status] ?? 'bg-gray-50 text-gray-700 ring-gray-200';
                        $dotColors = ['available' => 'bg-emerald-500', 'waiting' => 'bg-orange-500', 'occupied' => 'bg-red-500'];
                        $dotClass = $dotColors[$room->current_status] ?? 'bg-gray-500';
                    @endphp
                    <div class="border border-gray-100 rounded-xl p-4 hover:border-gray-200 hover:shadow-sm transition-all bg-gray-50/30">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-display font-bold text-ink text-base leading-none">{{ $room->name }}</p>
                                <p class="text-[11px] font-medium tracking-widest text-ink/40 uppercase mt-1">LT {{ $room->floor }} &bull; {{ $room->room_type }}</p>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[10px] font-bold uppercase tracking-widest rounded-full ring-1 {{ $badgeClass }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
                                {{ ucfirst($room->current_status) }}
                            </span>
                        </div>
                        @if($room->display_group)
                        <div class="mt-3 flex items-center gap-1.5 text-xs font-medium text-gray-500">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/></svg>
                            {{ $room->display_group }}
                        </div>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                {{ $rooms->links() }}
            </div>
        </div>

        <div class="md:col-span-7 editorial-panel bg-gray-50/50 p-6 flex flex-col items-center justify-center min-h-[500px]">
            <div class="w-20 h-20 rounded-full bg-orange-50 border border-orange-100 flex items-center justify-center text-orange-300 mb-4 shadow-sm">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" /></svg>
            </div>
            <h2 class="font-display text-lg font-bold text-ink mb-1">Visualisasi Denah Tersedia Segera</h2>
            <p class="text-sm text-ink/50 text-center max-w-sm">Integrasi modul peta interaktif sedang dalam tahap pengembangan. Untuk sementara silakan gunakan navigasi daftar indeks di samping.</p>
        </div>
    </div>
@endsection
