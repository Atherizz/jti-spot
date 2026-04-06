@extends('layouts.dashboard')

@section('title', 'Profil Saya')

@section('content')
	<div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-800 via-slate-700 to-teal-700 p-6 sm:p-8 shadow-lg border border-white/10">
		<div class="absolute -top-16 -right-20 w-64 h-64 rounded-full bg-teal-300/15 blur-3xl"></div>
		<div class="absolute -bottom-20 -left-20 w-64 h-64 rounded-full bg-cyan-200/10 blur-3xl"></div>

		<div class="relative grid grid-cols-1 xl:grid-cols-3 gap-6">
			<div class="xl:col-span-2 rounded-2xl bg-white/10 border border-white/15 backdrop-blur-sm overflow-hidden">
				<div class="px-5 sm:px-6 py-5 border-b border-white/10 flex items-start justify-between gap-4">
					<div class="flex items-start gap-4">
						<div class="w-16 h-16 rounded-2xl bg-white/15 border border-white/20 text-white flex items-center justify-center text-2xl font-extrabold">
							{{ strtoupper(substr($user->name, 0, 1)) }}
						</div>
						<div>
							<p class="text-xs uppercase tracking-[0.2em] font-semibold text-slate-300 mb-1">Profil Akun</p>
							<h1 class="text-2xl sm:text-3xl font-extrabold text-white">{{ $user->name }}</h1>
							<p class="text-sm text-slate-200 mt-1">{{ $roleLabel }} &bull; {{ $user->email }}</p>
						</div>
					</div>

					<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-teal-300/20 text-teal-100 border border-teal-200/25">
						Akun Aktif
					</span>
				</div>

				<div class="p-5 sm:p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
					<div>
						<p class="text-xs font-semibold uppercase tracking-wider text-slate-300">Nama Lengkap</p>
						<p class="text-sm font-semibold text-white mt-1">{{ $user->name }}</p>
					</div>
					<div>
						<p class="text-xs font-semibold uppercase tracking-wider text-slate-300">Email</p>
						<p class="text-sm font-semibold text-white mt-1">{{ $user->email }}</p>
					</div>
					<div>
						<p class="text-xs font-semibold uppercase tracking-wider text-slate-300">NIM/NIP</p>
						<p class="text-sm font-semibold text-white mt-1">{{ $user->reg_number ?? '-' }}</p>
					</div>
					<div>
						<p class="text-xs font-semibold uppercase tracking-wider text-slate-300">Role</p>
						<p class="text-sm font-semibold text-white mt-1">{{ $roleLabel }}</p>
					</div>
					<div>
						<p class="text-xs font-semibold uppercase tracking-wider text-slate-300">Kelas</p>
						<p class="text-sm font-semibold text-white mt-1">
							@if ($user->classGroup)
								{{ $user->classGroup->major }} {{ $user->classGroup->name }}
							@else
								-
							@endif
						</p>
					</div>
					<div>
						<p class="text-xs font-semibold uppercase tracking-wider text-slate-300">Bergabung Sejak</p>
						<p class="text-sm font-semibold text-white mt-1">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</p>
					</div>
				</div>
			</div>

			<div class="space-y-6">
				<div class="rounded-2xl bg-white/10 border border-white/15 backdrop-blur-sm p-5">
					<p class="text-xs uppercase tracking-[0.15em] font-semibold text-slate-300">Kelengkapan Profil</p>
					<p class="text-3xl font-extrabold text-white mt-2">{{ $profileCompletion }}%</p>
					<div class="mt-3 h-2 rounded-full bg-white/15 overflow-hidden">
						<div class="h-full bg-teal-300" style="width: {{ $profileCompletion }}%"></div>
					</div>
				</div>

				<div class="rounded-2xl bg-white/10 border border-white/15 backdrop-blur-sm overflow-hidden">
					<div class="px-5 py-4 border-b border-white/10">
						<h3 class="text-base font-bold text-white">Status Akun</h3>
					</div>
					<div class="p-5 space-y-3">
						<div class="flex items-center justify-between">
							<span class="text-sm text-slate-200">Verifikasi Email</span>
							@if ($user->email_verified_at)
								<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-teal-300/20 text-teal-100 border border-teal-200/25">Terverifikasi</span>
							@else
								<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-300/20 text-amber-100 border border-amber-200/25">Belum Verifikasi</span>
							@endif
						</div>
						<div class="flex items-center justify-between">
							<span class="text-sm text-slate-200">Akses Sistem</span>
							<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-cyan-300/20 text-cyan-100 border border-cyan-200/25">Aktif</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="relative mt-8 rounded-2xl bg-white/10 border border-white/15 backdrop-blur-sm overflow-hidden">
			<div class="px-5 py-4 border-b border-white/10">
				<h3 class="text-base font-bold text-white">Ringkasan Cepat</h3>
			</div>
			<div class="p-5 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
				<div class="rounded-xl bg-white/10 border border-white/10 p-4">
					<p class="text-slate-300">Update Profil</p>
					<p class="mt-1 font-semibold text-white">Terbaru</p>
				</div>
				<div class="rounded-xl bg-white/10 border border-white/10 p-4">
					<p class="text-slate-300">Preferensi Notifikasi</p>
					<p class="mt-1 font-semibold text-white">Default</p>
				</div>
				<div class="rounded-xl bg-white/10 border border-white/10 p-4">
					<p class="text-slate-300">Keamanan Akun</p>
					<p class="mt-1 font-semibold text-teal-200">Baik</p>
				</div>
			</div>
		</div>
	</div>
@endsection
