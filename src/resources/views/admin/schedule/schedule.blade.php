@extends('layouts.dashboard')

@section('title', 'Semua Jadwal')

@section('content')

	@if (session('success'))
		<div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
			{{ session('success') }}
		</div>
	@endif

	@if (session('error'))
		<div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700">
			{{ session('error') }}
		</div>
	@endif

	@if ($errors->has('excel_file'))
		<div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700">
			{{ $errors->first('excel_file') }}
		</div>
	@endif

	<div class="flex items-start justify-between mb-6">
		<div>
			<h1 class="text-2xl sm:text-3xl font-extrabold text-indigo-900">Semua Jadwal</h1>
			<p class="text-sm text-gray-500 mt-1">Kelola semua jadwal kelas, cek slot harian, dan update data dari file Excel.</p>
		</div>
	</div>

	<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
		<div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
			<h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total Jadwal</h3>
			<p class="text-3xl font-extrabold text-indigo-900">{{ $stats['total'] }}</p>
		</div>
		<div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
			<h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Jadwal Hari Ini</h3>
			<p class="text-3xl font-extrabold text-indigo-900">{{ $stats['today'] }}</p>
		</div>
		<div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
			<h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Ruangan Terpakai</h3>
			<p class="text-3xl font-extrabold text-indigo-900">{{ $stats['rooms'] }}</p>
		</div>
		<div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
			<h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Kelas Terjadwal</h3>
			<p class="text-3xl font-extrabold text-indigo-900">{{ $stats['classes'] }}</p>
		</div>
	</div>

	<div class="bg-white rounded-2xl shadow-sm border border-gray-100">
		<div class="p-5 sm:p-6 border-b border-gray-100">
			<div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-5 sm:gap-8">
				<h2 class="text-lg font-bold text-gray-900">All Schedules</h2>

				<div class="w-full sm:w-auto space-y-3 sm:min-w-[420px]">
					<form method="POST" action="{{ route('admin.room.import') }}" enctype="multipart/form-data" class="flex flex-col sm:flex-row sm:items-center gap-2 w-full sm:w-auto">
						@csrf
						<input type="file" name="excel_file" accept=".xlsx,.xls,.csv"
							class="block w-full sm:w-64 text-sm text-gray-700 file:mr-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100" />
						<button type="submit" class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition-colors">
							Import Excel
						</button>
					</form>

					<form method="GET" action="{{ route('admin.schedules') }}" class="flex flex-col sm:flex-row sm:items-center gap-2 w-full sm:w-auto">
						<div class="relative w-full sm:w-[360px] flex-none">
							<svg class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />
							</svg>
							<input type="text" name="q" value="{{ request('q') }}" placeholder="Search schedules..."
								class="w-full pl-11 pr-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-100 focus:border-indigo-300 outline-none transition placeholder:text-gray-400" />
						</div>

						<select name="room_id" class="w-full sm:w-36 flex-none px-2.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-100 focus:border-indigo-300 outline-none text-gray-700">
							<option value="">Filter Room</option>
							@foreach ($rooms as $room)
								<option value="{{ $room->id }}" {{ (string) $selectedRoomId === (string) $room->id ? 'selected' : '' }}>
									{{ $room->room_code ?? $room->name }}
								</option>
							@endforeach
						</select>

						<button type="submit" class="inline-flex items-center justify-center w-12 h-12 rounded-xl border border-gray-200 text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors" title="Cari Jadwal">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18M6 12h12M10 20h4" />
							</svg>
						</button>
					</form>
				</div>
			</div>
		</div>

		<div class="overflow-x-auto">
			<table class="w-full">
				<thead>
					<tr class="bg-gray-50 border-b border-gray-100 text-left">
						<th class="px-5 py-3 text-[11px] font-semibold text-gray-600 uppercase tracking-wider">Room</th>
						<th class="px-5 py-3 text-[11px] font-semibold text-gray-600 uppercase tracking-wider">Class</th>
						<th class="px-5 py-3 text-[11px] font-semibold text-gray-600 uppercase tracking-wider">Course</th>
						<th class="px-5 py-3 text-[11px] font-semibold text-gray-600 uppercase tracking-wider">Day</th>
						<th class="px-5 py-3 text-[11px] font-semibold text-gray-600 uppercase tracking-wider">Time</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-100">
					@forelse ($schedules as $schedule)
						<tr class="hover:bg-gray-50 transition-colors text-sm text-gray-700">
							<td class="px-5 py-4 font-semibold text-gray-900">{{ $schedule->room?->room_code ?? ('ROOM-' . $schedule->room_id) }}</td>
							<td class="px-5 py-4">{{ ($schedule->classGroup?->major ?? '-') . ' ' . ($schedule->classGroup?->name ?? '-') }}</td>
							<td class="px-5 py-4">{{ $schedule->course_name }}</td>
							<td class="px-5 py-4">
								@php
									$dayLabel = match ((int) $schedule->day_of_week) {
										0 => 'Minggu',
										1 => 'Senin',
										2 => 'Selasa',
										3 => 'Rabu',
										4 => 'Kamis',
										5 => 'Jumat',
										6 => 'Sabtu',
										default => '-',
									};
								@endphp
								{{ $dayLabel }}
							</td>
							<td class="px-5 py-4">{{ substr((string) $schedule->start_time, 0, 5) }} - {{ substr((string) $schedule->end_time, 0, 5) }}</td>
						</tr>
					@empty
						<tr>
							<td colspan="5" class="px-5 py-8 text-center text-sm text-gray-500">No schedules found.</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>

		<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-5 py-4 border-t border-gray-100 text-sm text-gray-500">
			<p>Showing {{ $schedules->count() }} of {{ $schedules->total() }} schedule entries</p>
			@if($schedules->hasPages())
			<div class="flex items-center gap-2">
				@if($schedules->onFirstPage())
					<span class="px-3 py-1.5 rounded-lg border border-gray-200 text-gray-400 cursor-not-allowed">Prev</span>
				@else
					<a href="{{ $schedules->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50 transition-colors">Prev</a>
				@endif

				@php
					$window = 2;
					$from = max($schedules->currentPage() - $window, 1);
					$to = min($schedules->currentPage() + $window, $schedules->lastPage());
				@endphp

				@if($from > 1)
					<a href="{{ $schedules->url(1) }}" class="px-3 py-1.5 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50 transition-colors">1</a>
					@if($from > 2)
						<span class="px-2 text-gray-400">...</span>
					@endif
				@endif

				@for($page = $from; $page <= $to; $page++)
					@if($page == $schedules->currentPage())
						<span class="px-3 py-1.5 rounded-lg bg-indigo-600 text-white font-semibold">{{ $page }}</span>
					@else
						<a href="{{ $schedules->url($page) }}" class="px-3 py-1.5 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50 transition-colors">{{ $page }}</a>
					@endif
				@endfor

				@if($to < $schedules->lastPage())
					@if($to < $schedules->lastPage() - 1)
						<span class="px-2 text-gray-400">...</span>
					@endif
					<a href="{{ $schedules->url($schedules->lastPage()) }}" class="px-3 py-1.5 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50 transition-colors">{{ $schedules->lastPage() }}</a>
				@endif

				@if($schedules->hasMorePages())
					<a href="{{ $schedules->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50 transition-colors">Next</a>
				@else
					<span class="px-3 py-1.5 rounded-lg border border-gray-200 text-gray-400 cursor-not-allowed">Next</span>
				@endif
			</div>
			@endif
		</div>
	</div>

@endsection
