@extends('layouts.app')

@section('content')
    <!-- Editorial Formal Header -->
    <div class="mb-10 pb-8 stagger-1 relative pt-4">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 relative z-10">
            <div class="max-w-2xl text-ink">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="font-display font-semibold uppercase tracking-widest text-[11px] text-ink/50">JTI-Spot Live Radar</span>
                </div>
                <h1 class="font-display text-4xl md:text-5xl font-bold tracking-tight leading-tight mb-3">
                    Status Ketersediaan <br>Ruang Kuliah & Lab
                </h1>
                <p class="text-base font-medium max-w-lg mt-3 text-ink/60">
                    Pantau ketersediaan lab dan ruang kelas secara real-time berdasarkan data sinkronisasi otomatis.
                </p>
            </div>
            <div class="editorial-panel bg-white px-6 py-4 flex flex-col justify-center items-center text-center self-start md:self-end">
                <span class="block text-[10px] font-semibold uppercase tracking-widest text-ink/40 mb-1">Update Terakhir</span>
                <span class="font-display text-lg font-bold text-ink">1 Menit Lalu</span>
            </div>
        </div>
        <div class="absolute left-0 top-0 w-64 h-64 bg-orange-50 rounded-full blur-3xl -translate-x-1/4 -translate-y-1/4 pointer-events-none z-0"></div>
    </div>

    <!-- Elegant Data Tracker -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-10 stagger-2">
        
        <!-- Main Highlight -->
        <div class="md:col-span-5 editorial-panel bg-emerald-500 text-white p-8 flex flex-col justify-between min-h-[220px] relative overflow-hidden group">
            <div class="absolute right-0 bottom-0 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-colors"></div>
            <div class="flex justify-between items-start pb-4 mb-2 relative z-10">
                <h3 class="font-display font-bold text-lg tracking-tight">Tersedia Sekarang</h3>
                <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14z"/></svg>
                </div>
            </div>
            <div class="relative z-10">
                <div class="font-display text-6xl font-bold tracking-tight mb-3">{{ $stats['available'] ?? 0 }}</div>
                <div class="font-medium bg-white/10 text-white inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs box-shadow-sm backdrop-blur-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    <span>+{{ max(0, ($stats['available'] ?? 0) - ($stats['occupied'] ?? 0)) }} dibanding terisi</span>
                </div>
            </div>
        </div>

        <div class="md:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Secondary Data -->
            <div class="editorial-panel bg-white p-6 flex flex-col relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-orange-50 rounded-full blur-xl"></div>
                <h3 class="font-display font-semibold text-[11px] uppercase tracking-widest text-ink/40 mb-6">Kosong &lt; 15 Menit</h3>
                <div class="mt-auto relative z-10">
                    <div class="font-display text-4xl font-bold mb-1 text-orange-600">{{ $stats['soon'] ?? 0 }}</div>
                    <p class="font-medium text-xs text-ink/50">Ruang segera bebas digunakan.</p>
                </div>
            </div>
            
            <div class="editorial-panel bg-white p-6 flex flex-col relative">
                <h3 class="font-display font-semibold text-[11px] uppercase tracking-widest text-ink/40 mb-6">Ruang Terpakai</h3>
                <div class="mt-auto">
                    <div class="font-display text-4xl font-bold mb-3 text-ink">{{ $stats['occupied'] ?? 0 }}</div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="bg-orange-600 h-full rounded-full" style="width: {{ $rooms->total() ? round(($stats['occupied'] ?? 0) / $rooms->total() * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
            
            <div class="sm:col-span-2 editorial-panel bg-ink text-white p-6 flex items-center justify-between">
                <div>
                    <h3 class="font-display font-medium text-[11px] uppercase tracking-widest text-white/50 mb-2">Penggunaan Lab Aktual</h3>
                    <div class="font-display text-3xl font-bold text-white">{{ $stats['labUsage'] ?? 0 }}%</div>
                </div>
                <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Elegant Filter Bar -->
    <div class="bg-white border rounded-2xl border-gray-100 shadow-sm p-3 mb-8 flex flex-col md:flex-row justify-between items-center gap-4 stagger-3">
        @php $currentFloor = request('floor'); @endphp
        <div class="flex items-center gap-1.5 bg-gray-50/50 p-1.5 rounded-xl border border-gray-100 w-full md:w-auto overflow-x-auto">
            <a href="{{ request()->fullUrlWithQuery(['floor' => null, 'page' => null]) }}" 
                class="px-4 py-2 font-medium text-xs rounded-lg transition-all {{ is_null($currentFloor) ? 'bg-white text-ink shadow-sm ring-1 ring-gray-200' : 'text-gray-500 hover:text-ink' }}">
                Semua Lantai
            </a>
            @foreach([5, 6, 7, 8] as $floor)
                <a href="{{ request()->fullUrlWithQuery(['floor' => $floor, 'page' => null]) }}" 
                    class="px-4 py-2 font-medium text-xs rounded-lg transition-all whitespace-nowrap {{ $currentFloor == $floor ? 'bg-white text-ink shadow-sm ring-1 ring-gray-200' : 'text-gray-500 hover:text-ink' }}">
                    Lantai {{ $floor }}
                </a>
            @endforeach
        </div>
        
        <form method="GET" action="{{ url()->current() }}" class="w-full md:w-auto relative group">
            @if(request('floor')) <input type="hidden" name="floor" value="{{ request('floor') }}"> @endif
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ruangan (Mis. LSI-1)" class="w-full sm:w-64 pl-9 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl font-medium placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-300 text-sm transition-all shadow-sm">
        </form>
    </div>
    
    <!-- Room Grid Soft Edition -->
    <div id="room-results" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 stagger-4">
        @foreach($rooms as $room)
            @php
                $statusColors = ['available' => 'bg-emerald-50 text-emerald-700 ring-emerald-200', 'waiting' => 'bg-orange-50 text-orange-700 ring-orange-200', 'occupied' => 'bg-red-50 text-red-700 ring-red-200'];
                $btnColor = $statusColors[$room->current_status] ?? 'bg-gray-50 text-gray-700 ring-gray-200';
                
                $dotColors = ['available' => 'bg-emerald-500', 'waiting' => 'bg-orange-500', 'occupied' => 'bg-red-500'];
                $dotColor = $dotColors[$room->current_status] ?? 'bg-gray-500';

                $progressColors = ['available' => 'bg-emerald-500', 'waiting' => 'bg-orange-500', 'occupied' => 'bg-red-500'];
                $pColor = $progressColors[$room->current_status] ?? 'bg-gray-500';

                $progress = 0;
                $durationText = 'Kosong saat ini';
                $endTime = null;
                if ($room->current_schedule) {
                    $end = \Carbon\Carbon::createFromFormat('H:i:s', $room->current_schedule->end_time);
                    $now = \Carbon\Carbon::now();
                    $remaining = max(0, round($now->diffInMinutes($end, false)));
                    $durationText = $remaining > 0 ? "Selesai dalam {$remaining} mins" : 'Selesai';
                    $start = \Carbon\Carbon::createFromFormat('H:i:s', $room->current_schedule->start_time);
                    $total = max(1, $start->diffInMinutes($end));
                    $progress = min(100, max(0, round((($total - $remaining) / $total) * 100)));
                    $endTime = $room->current_schedule->end_time;
                }
            @endphp

            <div class="editorial-panel bg-white flex flex-col overflow-hidden relative hover:shadow-lg transition-all transform hover:-translate-y-1">
                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="font-display text-lg font-bold tracking-tight text-ink">{{ $room->name }}</h3>
                            <div class="text-[11px] font-medium tracking-widest text-ink/40 mt-0.5 uppercase">{{ $room->room_type }} &bull; LT {{ $room->floor }}</div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[10px] font-bold uppercase tracking-widest rounded-full ring-1 {{ $btnColor }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                            {{ ucfirst($room->current_status) }}
                        </span>
                    </div>

                    <div class="mb-5 flex-1 mt-2">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422M12 20.5l9-5-9-5-9 5 9 5z"/></svg>
                            <span class="font-medium text-sm text-ink leading-tight">{{ $room->display_group ?? 'Tidak ada jadwal terdaftar' }}</span>
                        </div>
                    </div>

                    <div class="mt-auto pt-4 border-t border-gray-100">
                        <div class="flex justify-between text-xs font-medium mb-2">
                            <span class="text-gray-500">{{ $durationText }}</span>
                            @if($endTime)
                                <span class="text-ink font-semibold">{{ $endTime }}</span>
                            @endif
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-1">
                            <div class="h-full rounded-full {{ $pColor }}" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                </div>
                <a href="{{ url('/peta-ruang?floor=' . $room->floor . '&room=' . strtolower($room->room_code)) }}" class="mt-3 flex items-center justify-center gap-2 py-2 px-4 bg-indigo-50 text-indigo-700 rounded-lg text-xs font-semibold hover:bg-indigo-100 transition-all border border-indigo-100 group">
                    <svg class="w-3.5 h-3.5 text-indigo-500 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Lihat di Peta
                </a>
            </div> @endforeach </div> <div class="mt-8">
        {{ $rooms->links() }}
    </div>
@endsection