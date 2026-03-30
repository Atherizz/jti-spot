@extends('layouts.dashboard')

@section('title', 'Edit Pengguna')

@section('content')
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-indigo-900">Edit Pengguna</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui data akun pengguna sesuai kebutuhan.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')
        @include('admin.users._form')
    </form>
@endsection
