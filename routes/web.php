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
    Route::get('/dashboard/student', function () {
        return view('dashboard.student.home');
    })->name('dashboard.student.home');
});

Route::middleware(['auth', 'can:admin'])->group(function () {
    Route::get('/dashboard/admin', function () {
        return view('dashboard.admin.home');
    })->name('dashboard.admin.home');
});

