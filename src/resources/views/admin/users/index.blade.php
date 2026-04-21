@extends('layouts.dashboard')

@section('title', 'Manajemen Pengguna')

@section('content')
    @if (session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-orange-900">Manajemen Pengguna</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola akun admin, ketua kelas, dan mahasiswa dalam satu tempat.</p>
        </div>
        <div class="hidden lg:flex items-center gap-3">
            <div class="flex items-center gap-2 px-3 py-2 rounded-xl bg-white border border-gray-200 shadow-sm text-xs text-gray-600">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                Sinkronisasi aktif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6 mb-6">
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total Pengguna</h3>
            <p class="text-3xl font-extrabold text-orange-900">{{ number_format($stats['total']) }}</p>
            <p class="text-xs text-gray-500 mt-2">Seluruh akun terdaftar</p>
        </div>

        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Administrator</h3>
            <p class="text-3xl font-extrabold text-orange-900">{{ number_format($stats['admin']) }}</p>
            <p class="text-xs text-gray-500 mt-2">Akses penuh sistem</p>
        </div>

        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Ketua Kelas</h3>
            <p class="text-3xl font-extrabold text-orange-900">{{ number_format($stats['class_rep']) }}</p>
            <p class="text-xs text-gray-500 mt-2">Koordinator kelas aktif</p>
        </div>

        <div class="bg-gradient-to-br from-orange-600 to-orange-800 rounded-2xl p-5 sm:p-6 shadow-sm text-white">
            <h3 class="text-xs font-semibold text-orange-200 uppercase tracking-wider mb-1">Mahasiswa</h3>
            <p class="text-3xl font-extrabold">{{ number_format($stats['student']) }}</p>
            <p class="text-xs text-white/90 mt-2">Akun mahasiswa aktif</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-gray-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Daftar Pengguna</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Pencarian berdasarkan nama, email, NIM/NIP, atau role.</p>
                </div>

                <div class="w-full md:w-auto flex items-center gap-2.5">
                    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white bg-orange-900 rounded-xl hover:bg-orange-800 transition-colors whitespace-nowrap">
                        + Tambah User
                    </a>

                    <form method="GET" action="{{ route('admin.users.index') }}" class="w-full">
                        <div class="relative md:w-80">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input
                            type="text"
                            name="q"
                            value="{{ $search }}"
                            placeholder="Cari nama, email, NIM/NIP, role..."
                            class="w-full pl-10 pr-24 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                        >
                            <button
                                type="submit"
                                class="absolute right-1.5 top-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-orange-900 rounded-lg hover:bg-orange-800 transition-colors"
                            >
                                Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px]">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pengguna</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NIM/NIP</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-gray-500">{{ $users->firstItem() + $loop->index }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-orange-100 flex items-center justify-center text-orange-700 text-xs font-bold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">Terdaftar {{ $user->created_at?->format('d M Y') ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $user->reg_number ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                @if ($user->classGroup)
                                    {{ $user->classGroup->major }} {{ $user->classGroup->name }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $roleMap = [
                                        'admin' => ['label' => 'Admin', 'class' => 'bg-orange-50 text-orange-700 border-orange-100'],
                                        'class_rep' => ['label' => 'Perwakilan Kelas', 'class' => 'bg-orange-50 text-orange-700 border-orange-100'],
                                        'student' => ['label' => 'Mahasiswa', 'class' => 'bg-emerald-50 text-emerald-700 border-emerald-100'],
                                    ];

                                    $role = $roleMap[$user->role] ?? ['label' => ucfirst($user->role), 'class' => 'bg-gray-50 text-gray-700 border-gray-100'];
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border {{ $role['class'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current opacity-80"></span>
                                    {{ $role['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-orange-700 bg-orange-50 border border-orange-100 rounded-lg hover:bg-orange-100 transition-colors">
                                        Edit
                                    </a>

                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-red-700 bg-red-50 border border-red-100 rounded-lg hover:bg-red-100 transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center">
                                <p class="text-sm font-medium text-gray-700">Tidak ada pengguna ditemukan.</p>
                                <p class="text-xs text-gray-500 mt-1">Coba kata kunci lain untuk pencarian Anda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 sm:px-6 py-4 border-t border-gray-100 bg-gray-50/60">
            <div class="flex items-center justify-between gap-3">
                <p class="text-xs sm:text-sm text-gray-500">
                    Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} data
                </p>

                <div class="flex items-center gap-2">
                    <a
                        href="{{ $users->previousPageUrl() ?? '#' }}"
                        class="inline-flex items-center px-3 py-2 text-xs sm:text-sm font-semibold rounded-lg border transition-colors {{ $users->onFirstPage() ? 'border-gray-200 text-gray-400 bg-gray-100 pointer-events-none' : 'border-gray-200 text-gray-700 bg-white hover:bg-gray-50' }}"
                    >
                        Prev
                    </a>

                    <span class="text-xs sm:text-sm text-gray-500 px-1">
                        {{ $users->currentPage() }} / {{ max($users->lastPage(), 1) }}
                    </span>

                    <a
                        href="{{ $users->hasMorePages() ? $users->nextPageUrl() : '#' }}"
                        class="inline-flex items-center px-3 py-2 text-xs sm:text-sm font-semibold rounded-lg border transition-colors {{ $users->hasMorePages() ? 'border-orange-200 text-orange-700 bg-orange-50 hover:bg-orange-100' : 'border-gray-200 text-gray-400 bg-gray-100 pointer-events-none' }}"
                    >
                        Next
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

