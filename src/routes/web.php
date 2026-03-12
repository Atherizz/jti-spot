<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('guest');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'can:student'])->group(function () {
    Route::get('/student/dashboard', function () {
        return view('student.dashboard.home');
    })->name('student.dashboard.home');
});

Route::middleware(['auth', 'can:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard.home');
    })->name('admin.dashboard.home');
});

