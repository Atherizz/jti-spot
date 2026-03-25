@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-2">
            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20l9-7-9-7-9 7 9 7z"></path>
            </svg>
            <h1 class="text-2xl font-bold text-indigo-900">Peta Ruang</h1>
        </div>
        <a href="/" class="text-sm text-orange-600 hover:text-orange-700 font-semibold">Kembali ke Beranda</a>
    </div>

    <p class="text-sm text-gray-500 mb-6">Lihat status ruang secara visual berdasarkan lantai. Klik opsi lantai untuk fokus pada area tertentu.</p>

    <div class="flex flex-col md:flex-row gap-4 mb-8">
        @php
            $currentFloor = request('floor');
        @endphp

        <div class="flex flex-wrap gap-2 items-center">
            <a href="{{ request()->fullUrlWithQuery(['floor' => null]) }}" 
                class="border border-gray-200 px-4 py-2 rounded-md text-sm font-medium flex items-center gap-2 {{ is_null($currentFloor) ? 'bg-indigo-50 text-indigo-900 border-indigo-200' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                <svg class="w-4 h-4 {{ is_null($currentFloor) ? 'text-indigo-900' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                </svg>
                Semua Lantai
            </a>
    
            <div class="bg-white border border-gray-200 rounded-md flex overflow-hidden">
                @foreach([5, 6, 7, 8] as $floor)
                    <a href="{{ request()->fullUrlWithQuery(['floor' => $floor]) }}" 
                        class="px-4 py-2 text-sm font-medium transition-colors {{ $currentFloor == $floor ? 'bg-indigo-900 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                        Lantai {{ $floor }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="relative w-full md:w-auto">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" placeholder="Cari ruang (mis. LSI-1)" class="pl-10 pr-4 py-2 border border-gray-200 rounded-md text-sm focus:ring-orange-500 focus:border-orange-500 w-full sm:w-72 shadow-sm">
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Detail Lantai</h2>
            <div class="flex flex-col gap-3">
                @foreach($rooms as $room)
                    @php
                        $status = $room->current_status;
                        $statusClass = $status === 'available' ? 'emerald' : ($status === 'occupied' ? 'red' : 'orange');
                    @endphp
                    <div class="border border-gray-100 rounded-lg p-3">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-semibold text-indigo-900">{{ $room->name }} ({{ $room->room_type }})</p>
                                <p class="text-xs text-gray-500">Lantai {{ $room->floor }}</p>
                                @if($room->display_group)
                                    <p class="text-xs text-gray-500">{{ $room->display_group }}</p>
                                @endif
                            </div>
                            <span class="text-xs text-{{ $statusClass }}-700 bg-{{ $statusClass }}-50 border border-{{ $statusClass }}-100 px-2 py-1 rounded-full">{{ ucfirst($status) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Visual Peta</h2>
            <div class="h-80 bg-gray-100 rounded-lg border border-dashed border-gray-300 flex items-center justify-center text-gray-500 text-sm">
                <span>Area peta ruang akan ditampilkan di sini (komponen target: SVG/kanvas/leaflet).</span>
            </div>
        </div>
    </div>
@endsection