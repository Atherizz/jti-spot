@extends('layouts.dashboard')

@section('title', 'Tambah Pengguna')

@section('content')
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-indigo-900">Tambah Pengguna</h1>
            <p class="text-sm text-gray-500 mt-1">Buat akun baru untuk admin, ketua kelas, atau mahasiswa.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        @include('admin.users._form')
    </form>
@endsection
