@extends('layouts.app')

@section('content')
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-2">
            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            <h1 class="text-2xl font-bold text-indigo-900">Live Status Ruang</h1>
        </div>
        <span class="text-sm text-gray-500">Diperbarui 1 menit lalu</span>
    </div>

    <!-- Stat Cards Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Available Card -->
        <div class="bg-emerald-500 rounded-xl p-6 text-white shadow-sm relative overflow-hidden">
            <div class="flex justify-between items-start">
                <h3 class="text-emerald-50 text-sm font-medium mb-1">Tersedia Sekarang</h3>
                <svg class="w-5 h-5 text-emerald-200 opacity-80" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14z"/></svg>
            </div>
            <div class="text-4xl font-bold mb-4">{{ $stats['available'] ?? 0 }}</div>
            <div class="text-emerald-100 text-sm flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                +{{ max(0, ($stats['available'] ?? 0) - ($stats['occupied'] ?? 0)) }} dibanding terisi
            </div>
        </div>
        
        <!-- Occupied Card -->
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
            <div class="flex justify-between items-start mb-2">
                <h3 class="text-gray-500 text-sm font-medium">Ruang Terpakai</h3>
                <div class="bg-gray-50 p-1.5 rounded-lg">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-indigo-900 mb-4">{{ $stats['occupied'] ?? 0 }}</div>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                <div class="bg-rose-500 h-1.5 rounded-full" style="width: {{ $rooms->total() ? round(($stats['occupied'] ?? 0) / $rooms->total() * 100) : 0 }}%"></div>
            </div>
        </div>

        <!-- Free in < 15m -->
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
            <div class="flex justify-between items-start mb-2">
                <h3 class="text-gray-500 text-sm font-medium">Kosong &lt; 15m</h3>
                <div class="bg-orange-50 p-1.5 rounded-lg">
                    <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-indigo-900 mb-4">{{ $stats['soon'] ?? 0 }}</div>
            <div class="text-gray-400 text-sm">
                Ruang akan bebas dalam 15 menit
            </div>
        </div>
        
        <!-- Lab Usage -->
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
            <div class="flex justify-between items-start mb-2">
                <h3 class="text-gray-500 text-sm font-medium">Penggunaan Lab</h3>
                <div class="bg-rose-50 p-1.5 rounded-lg">
                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-indigo-900 mb-4">{{ $stats['labUsage'] ?? 0 }}%</div>
            <div class="text-rose-500 text-sm">
                Persentase lab terpakai saat ini
            </div>
        </div>
    </div>
    
    <!-- Filter Bar -->
    <div class="flex flex-col md:flex-row justify-between mb-6 gap-4">
        @php
            $currentFloor = request('floor');
        @endphp

        <div class="flex flex-wrap gap-2 items-center">
            <a href="{{ request()->fullUrlWithQuery(['floor' => null, 'page' => null]) }}" 
                class="border border-gray-200 px-4 py-2 rounded-md text-sm font-medium flex items-center gap-2 {{ is_null($currentFloor) ? 'bg-indigo-50 text-indigo-900 border-indigo-200' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                <svg class="w-4 h-4 {{ is_null($currentFloor) ? 'text-indigo-900' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                </svg>
                Semua Lantai
            </a>
    
            <div class="bg-white border border-gray-200 rounded-md flex overflow-hidden">
                @foreach([5, 6, 7, 8] as $floor)
                    <a href="{{ request()->fullUrlWithQuery(['floor' => $floor, 'page' => null]) }}" 
                        class="px-4 py-2 text-sm font-medium transition-colors {{ $currentFloor == $floor ? 'bg-indigo-900 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                        Lantai {{ $floor }}
                    </a>
                @endforeach
            </div>
        </div>
        
        <form method="GET" action="{{ url()->current() }}" class="relative w-full md:w-auto">
            @if(request('floor'))
                <input type="hidden" name="floor" value="{{ request('floor') }}">
            @endif
            
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ruang (mis. LSI-1)" class="pl-10 pr-4 py-2 border border-gray-200 rounded-md text-sm focus:ring-orange-500 focus:border-orange-500 w-full sm:w-64 shadow-sm">
        </form>
    </div>
    
    <!-- Room Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($rooms as $room)
            @php
                $statusColors = ['available' => 'emerald', 'waiting' => 'orange', 'occupied' => 'red'];
                $color = $statusColors[$room->current_status] ?? 'gray';
                $progress = 0;
                $durationText = 'Tidak ada jadwal saat ini';
                $endTime = null;
                if ($room->current_schedule) {
                    $end = \Carbon\Carbon::createFromFormat('H:i:s', $room->current_schedule->end_time);
                    $now = \Carbon\Carbon::now();
                    $remaining = max(0, round($now->diffInMinutes($end, false)));
                    $durationText = $remaining > 0 ? "Berakhir dalam {$remaining} mnt" : 'Selesai';
                    $start = \Carbon\Carbon::createFromFormat('H:i:s', $room->current_schedule->start_time);
                    $total = max(1, $start->diffInMinutes($end));
                    $progress = min(100, max(0, round((($total - $remaining) / $total) * 100)));
                    $endTime = $room->current_schedule->end_time;
                }
            @endphp

            <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm flex flex-col">
                <div class="flex justify-between items-start mb-1">
                    <h3 class="text-xl font-bold text-indigo-900">{{ $room->name }}</h3>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-{{ $color }}-50 text-{{ $color }}-700 border border-{{ $color }}-100">
                        <span class="w-1.5 h-1.5 bg-{{ $color }}-500 rounded-full mr-1.5"></span> {{ ucfirst($room->current_status) }}
                    </span>
                </div>
                <div class="text-xs text-gray-400 mb-4">{{ $room->room_type }} &bull; LANTAI {{ $room->floor }}</div>

                <div class="flex items-start gap-2 mb-4">
                    <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422M12 20.5l9-5-9-5-9 5 9 5z"/></svg>
                    <div>
                        <div class="text-sm font-medium text-gray-900">{{ $room->display_group ?? 'Tidak ada kelas' }}</div>
                    </div>
                </div>

                <div class="mt-auto">
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-gray-500">{{ $durationText }}</span>
                        @if($endTime)
                            <span class="text-gray-900 font-medium">{{ $endTime }}</span>
                        @endif
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1">
                        <div class="bg-{{ $color }}-500 h-1 rounded-full" style="width: {{ $progress }}%"></div>
                    </div>
                </div>
            </div> @endforeach </div> <div class="mt-8">
        {{ $rooms->links() }}
    </div>
@endsection