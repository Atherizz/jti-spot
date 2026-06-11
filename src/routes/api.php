<?php

use App\Http\Controllers\Api\ClassGroupController;
use App\Http\Controllers\Api\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('/class-groups', [ClassGroupController::class, 'index']);
Route::get('/schedules', [ScheduleController::class, 'index']);
