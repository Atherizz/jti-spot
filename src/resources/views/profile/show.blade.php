@extends('layouts.dashboard')

@section('title', 'Profil Saya')

@section('content')
	@php
		$isStudentRole = $user->role === 'student';
	@endphp
	
	{{-- Formal Header --}}
	<div class="mb-8 stagger-1">
		<div class="flex items-center gap-2 mb-2">
			<div class="w-8 h-px bg-orange-500"></div>
			<span class="font-display font-semibold uppercase tracking-widest text-[10px] text-ink/50">Pengaturan Akun</span>
		</div>
		<h1 class="font-display text-3xl sm:text-4xl font-bold tracking-tight text-ink">
			Profil & Personalisasi
		</h1>
	</div>

	@if (session('success'))
		<div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 flex items-center gap-2">
			<svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
			{{ session('success') }}
		</div>
	@endif

	@if ($errors->has('token'))
		<div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800 flex items-center gap-2">
			<svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
			{{ $errors->first('token') }}
		</div>
	@endif

	<div class="grid grid-cols-1 xl:grid-cols-12 gap-6 stagger-2">
		
		{{-- Main ID Card (Editorial Luxury Design) --}}
		<div class="xl:col-span-8">
			<div class="editorial-panel bg-white flex flex-col relative overflow-hidden h-full">
				
				{{-- Header Background --}}
				<div class="h-32 bg-gradient-to-r from-orange-50 to-emerald-50 border-b border-gray-100 relative">
					<div class="absolute inset-0 bg-white/20 backdrop-blur-sm"></div>
				</div>

				{{-- ID Card Body --}}
				<div class="px-8 pb-8 pt-0 relative z-10">
					<div class="flex flex-col sm:flex-row gap-6 items-start sm:items-end -mt-12 mb-8">
						<div class="w-24 h-24 rounded-2xl bg-white border border-gray-100 shadow-sm flex flex-col items-center justify-center shrink-0">
							<span class="font-display text-4xl font-bold text-orange-600">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
						</div>
						<div class="flex-1 min-w-0 pb-1 w-full">
							<div class="flex justify-between items-end w-full border-b border-gray-100 pb-4">
								<div>
									<h2 class="font-display text-2xl font-bold tracking-tight text-ink truncate">{{ $user->name }}</h2>
									<p class="text-sm font-medium text-gray-500 mt-1">{{ $user->email }}</p>
								</div>
								<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">
									{{ $roleLabel }}
								</span>
							</div>
						</div>
					</div>

					{{-- ID Card Data Grid --}}
					<div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6 mt-4">
						
						{{-- Left Column --}}
						<div class="space-y-6">
							<div>
								<p class="text-xs font-medium text-gray-500 mb-1">Nama Lengkap</p>
								<p class="font-semibold text-ink">{{ $user->name }}</p>
							</div>
							<div>
								<p class="text-xs font-medium text-gray-500 mb-1">Nomor Induk / Identitas Akademik</p>
								<p class="font-semibold text-ink">{{ $user->reg_number ?? 'Belum Dimasukkan' }}</p>
							</div>
						</div>

						{{-- Right Column --}}
						<div class="space-y-6">
							<div>
								<p class="text-xs font-medium text-gray-500 mb-1">Afiliasi Kelas Tertaut</p>
								<p class="font-semibold text-ink flex items-center gap-2">
									@if ($user->classGroup)
										<svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
										{{ $user->classGroup->major }} {{ $user->classGroup->name }}
									@else
										<span class="text-gray-400">Tidak Terdaftar</span>
									@endif
								</p>
							</div>
							<div>
								<p class="text-xs font-medium text-gray-500 mb-1">Akun Dibuat Sejak</p>
								<p class="font-semibold text-ink">{{ $user->created_at ? $user->created_at->format('j F Y, H:i') : '-' }}</p>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>

		{{-- Right Sidebar --}}
		<div class="xl:col-span-4 space-y-6 flex flex-col">
			
			{{-- Completion Status --}}
			<div class="editorial-panel bg-white p-6 relative overflow-hidden group border-orange-100 bg-white">
				<div class="absolute -right-8 -top-8 w-32 h-32 bg-orange-50 rounded-full blur-2xl group-hover:bg-orange-100/50 transition-colors"></div>
				<div class="relative z-10">
					<div class="flex items-center justify-between mb-4">
						<div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-600">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
						</div>
						<span class="font-display text-3xl font-bold text-ink">{{ $profileCompletion }}%</span>
					</div>
					<h3 class="font-semibold text-sm text-ink mb-1">Status Kelengkapan Profil</h3>
					<p class="text-xs text-gray-500 mb-4">Lengkapi data Anda untuk membuka fitur analitik penuh.</p>
					
					<div class="w-full bg-gray-100 rounded-full h-1.5">
						<div class="bg-orange-500 h-full rounded-full transition-all duration-1000" style="width: {{ $profileCompletion }}%"></div>
					</div>
				</div>
			</div>

			{{-- Security Status --}}
			<div class="editorial-panel bg-white flex-1 flex flex-col">
				<div class="p-5 border-b border-gray-100">
					<h3 class="font-semibold text-sm text-ink">Verifikasi Keamanan</h3>
				</div>
				
				<div class="p-5 flex-1 flex flex-col gap-4">
					<div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 border border-gray-100">
						<div class="flex items-center gap-3">
							<div class="w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center text-gray-500">
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
							</div>
							<span class="text-sm font-medium text-ink">Alamat Email</span>
						</div>
						@if ($user->email_verified_at)
							<span class="text-xs font-semibold text-emerald-600 px-2 py-1 bg-emerald-50 rounded-lg">Terverifikasi</span>
						@else
							<span class="text-xs font-semibold text-orange-600 px-2 py-1 bg-orange-50 rounded-lg">Tertunda</span>
						@endif
					</div>

					<div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 border border-gray-100">
						<div class="flex items-center gap-3">
							<div class="w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center text-gray-500">
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
							</div>
							<span class="text-sm font-medium text-ink">Akses Sistem</span>
						</div>
						<span class="text-xs font-semibold text-emerald-600 px-2 py-1 bg-emerald-50 rounded-lg">Diizinkan</span>
					</div>
				</div>
			</div>

		</div>
	</div>

	{{-- Quick Settings Menus --}}
	<div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6 stagger-3">
		<a href="#" class="editorial-panel bg-white p-5 flex items-center gap-4 hover:border-orange-200 transition-colors group cursor-pointer">
			<div class="w-10 h-10 rounded-xl bg-gray-50 group-hover:bg-orange-50 border border-gray-100 group-hover:border-orange-100 flex items-center justify-center text-gray-500 group-hover:text-orange-600 transition-all">
				<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
			</div>
			<div>
				<p class="text-sm font-semibold text-ink">Perbarui Data Diri</p>
				<p class="text-xs text-gray-500 mt-0.5">Ubah nama atau pengaturan bio.</p>
			</div>
		</a>
		@if ($isStudentRole)
			<button type="button" onclick="document.getElementById('claim-token-modal').classList.remove('hidden')" class="editorial-panel bg-white p-5 flex items-center gap-4 hover:border-orange-200 transition-colors group cursor-pointer text-left">
				<div class="w-10 h-10 rounded-xl bg-gray-50 group-hover:bg-orange-50 border border-gray-100 group-hover:border-orange-100 flex items-center justify-center text-gray-500 group-hover:text-orange-600 transition-all">
					<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3zm0 2c-2.761 0-5 2.239-5 5h10c0-2.761-2.239-5-5-5zm7-1h-1V9a6 6 0 10-12 0v3H5v8h14v-8z" /></svg>
				</div>
				<div>
					<p class="text-sm font-semibold text-ink">Klaim Akses Token</p>
					<p class="text-xs text-gray-500 mt-0.5">Masukkan token untuk upgrade role ke ketua kelas.</p>
				</div>
			</button>
		@else
			<a href="#" class="editorial-panel bg-white p-5 flex items-center gap-4 hover:border-orange-200 transition-colors group cursor-pointer">
				<div class="w-10 h-10 rounded-xl bg-gray-50 group-hover:bg-orange-50 border border-gray-100 group-hover:border-orange-100 flex items-center justify-center text-gray-500 group-hover:text-orange-600 transition-all">
					<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
				</div>
				<div>
					<p class="text-sm font-semibold text-ink">Preferensi Notifikasi</p>
					<p class="text-xs text-gray-500 mt-0.5">Atur lansiran jadwal.</p>
				</div>
			</a>
		@endif
		<a href="#" class="editorial-panel bg-white p-5 flex items-center gap-4 hover:border-orange-200 transition-colors group cursor-pointer">
			<div class="w-10 h-10 rounded-xl bg-gray-50 group-hover:bg-orange-50 border border-gray-100 group-hover:border-orange-100 flex items-center justify-center text-gray-500 group-hover:text-orange-600 transition-all">
				<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
			</div>
			<div>
				<p class="text-sm font-semibold text-ink">Ganti Kata Sandi</p>
				<p class="text-xs text-gray-500 mt-0.5">Perbarui kunci akses keamanan.</p>
			</div>
		</a>
	</div>

	@if ($isStudentRole)
		<div id="claim-token-modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
			<div class="fixed inset-0 bg-ink/60 backdrop-blur-sm transition-opacity" onclick="document.getElementById('claim-token-modal').classList.add('hidden')"></div>
			<div class="relative editorial-panel bg-white shadow-2xl w-[90%] md:w-full mx-auto p-8 overflow-hidden transform transition-all" style="max-width: 480px;">
				<div class="absolute right-0 top-0 w-32 h-32 bg-orange-50 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

				<div class="relative z-10">
					<div class="flex items-center gap-3 mb-5">
						<div class="w-12 h-12 rounded-full bg-orange-50 border border-orange-100 flex items-center justify-center text-orange-600">
							<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3zm0 2c-2.761 0-5 2.239-5 5h10c0-2.761-2.239-5-5-5zm7-1h-1V9a6 6 0 10-12 0v3H5v8h14v-8z" /></svg>
						</div>
						<div>
							<h3 class="font-display text-2xl font-bold text-ink">Klaim Akses Token</h3>
							<p class="text-sm font-medium text-gray-500">Masukkan token kelas untuk aktivasi role ketua kelas.</p>
						</div>
					</div>

					<form id="claim-token-form" method="POST" action="{{ route('student.claim.class-rep-token') }}" class="space-y-5">
						@csrf
						<div>
							<label for="claim-token-input" class="block text-xs font-semibold uppercase tracking-widest text-ink/50 mb-2">Access Token</label>
							<input
								id="claim-token-input"
								type="text"
								name="token"
								value="{{ old('token') }}"
								maxlength="64"
								required
								placeholder="Contoh: TI2F-abc123"
								class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2.5 text-sm font-medium text-ink shadow-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-200"
							>
						</div>

						<div class="flex flex-col sm:flex-row items-center gap-3 w-full">
							<button type="button" onclick="document.getElementById('claim-token-modal').classList.add('hidden')" class="w-full sm:w-auto flex-1 px-4 py-3 bg-gray-50 hover:bg-gray-100 text-ink text-sm font-semibold rounded-xl transition-colors border border-gray-200">
								Batal
							</button>
							<button id="claim-token-submit-button" type="button" onclick="openClaimConfirmModal()" class="w-full sm:w-auto flex-1 px-4 py-3 bg-orange-600 hover:bg-orange-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">
								Klaim Token
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div id="claim-confirm-modal" class="hidden fixed inset-0 z-[101] flex items-center justify-center p-4">
			<div class="fixed inset-0 bg-ink/60 backdrop-blur-sm transition-opacity" onclick="document.getElementById('claim-confirm-modal').classList.add('hidden')"></div>
			<div class="relative editorial-panel bg-white shadow-2xl w-[90%] md:w-full mx-auto p-8 overflow-hidden transform transition-all" style="max-width: 460px;">
				<div class="absolute right-0 top-0 w-32 h-32 bg-orange-50 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

				<div class="relative z-10 text-center">
					<div class="w-16 h-16 rounded-full bg-orange-50 flex items-center justify-center mx-auto mb-5 ring-4 ring-white border border-orange-100">
						<svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
					</div>
					<h3 class="font-display text-2xl font-bold text-ink mb-2">Konfirmasi Klaim</h3>
					<p class="text-sm font-medium text-gray-600 mb-6">Setelah lanjut, role akun Anda akan diubah menjadi Ketua Kelas. Pastikan token yang dimasukkan sudah benar.</p>

					<div class="flex flex-col sm:flex-row items-center gap-3 w-full">
						<button type="button" onclick="document.getElementById('claim-confirm-modal').classList.add('hidden')" class="w-full sm:w-auto flex-1 px-4 py-3 bg-gray-50 hover:bg-gray-100 text-ink text-sm font-semibold rounded-xl transition-colors border border-gray-200">
							Batal
						</button>
						<button type="button" onclick="submitClaimTokenForm()" class="w-full sm:w-auto flex-1 px-4 py-3 bg-orange-600 hover:bg-orange-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">
							Ya, Ubah Role
						</button>
					</div>
				</div>
			</div>
		</div>

		@if ($errors->has('token'))
			<script>
				document.addEventListener('DOMContentLoaded', () => {
					document.getElementById('claim-token-modal')?.classList.remove('hidden');
				});
			</script>
		@endif

		<script>
			function openClaimConfirmModal() {
				const form = document.getElementById('claim-token-form');

				if (!form || !form.reportValidity()) {
					return;
				}

				document.getElementById('claim-confirm-modal')?.classList.remove('hidden');
			}

			function submitClaimTokenForm() {
				const form = document.getElementById('claim-token-form');
				const submitButton = document.getElementById('claim-token-submit-button');

				if (!form || !submitButton) {
					return;
				}

				submitButton.disabled = true;
				submitButton.classList.add('opacity-75', 'cursor-not-allowed');
				submitButton.innerHTML = 'Memproses...';

				form.submit();
			}
		</script>
	@endif

	@if (session('claim_success') && $user->role === 'class_rep')
		<div id="claim-success-modal" class="fixed inset-0 z-[101] flex items-center justify-center p-4">
			<div class="fixed inset-0 bg-ink/60 backdrop-blur-sm transition-opacity" onclick="document.getElementById('claim-success-modal').classList.add('hidden')"></div>
			<div class="relative editorial-panel bg-white shadow-2xl w-[90%] md:w-full mx-auto p-8 overflow-hidden transform transition-all" style="max-width: 460px;">
				<div class="absolute right-0 top-0 w-32 h-32 bg-emerald-50 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

				<div class="relative z-10 text-center">
					<div class="w-16 h-16 rounded-full bg-emerald-50 flex items-center justify-center mx-auto mb-5 ring-4 ring-white border border-emerald-100">
						<svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/></svg>
					</div>
					<h3 class="font-display text-2xl font-bold text-ink mb-2">Selamat!</h3>
					<p class="text-sm font-medium text-gray-600 mb-6">Anda sekarang terdaftar sebagai Ketua Kelas. Akses peran class representative sudah aktif.</p>

					<button type="button" onclick="document.getElementById('claim-success-modal').classList.add('hidden')" class="w-full px-4 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">
						Tutup
					</button>
				</div>
			</div>
		</div>
	@endif

@endsection

