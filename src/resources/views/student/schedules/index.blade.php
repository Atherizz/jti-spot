@extends('layouts.dashboard')

@section('title', 'Jadwal Kelas')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl sm:text-3xl font-extrabold text-indigo-900">Jadwal Kelas</h1>
    <p class="text-sm text-gray-500 mt-1">Kelas {{ $classLabel }} &bull; Lihat jadwal per hari dan sesi yang sedang berlangsung.</p>
</div>

<div class="space-y-4">
    @forelse($groupedSchedules as $day)
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-900">{{ $day['day'] }}</h2>
            @if($day['is_today'])
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                Hari Ini
            </span>
            @endif
        </div>

        <div class="space-y-3">
            @foreach($day['items'] as $item)
            <div class="rounded-xl border {{ $item['is_ongoing'] ? 'border-emerald-200 bg-emerald-50/50' : 'border-gray-100 bg-gray-50' }} p-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <p class="text-base font-semibold text-gray-900">{{ $item['course_name'] }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $item['room_name'] }}</p>
                    </div>
                    <div class="text-sm font-semibold {{ $item['is_ongoing'] ? 'text-emerald-700' : 'text-gray-700' }}">
                        {{ $item['time'] }}
                        @if($item['is_ongoing'])
                        <span class="ml-2 text-xs font-bold uppercase tracking-wide">Berlangsung</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm text-gray-500">
        Belum ada jadwal untuk kelas Anda.
    </div>
    @endforelse
</div>
@endsection
