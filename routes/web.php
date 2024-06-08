<?php

use App\Http\Controllers\PengajuanController;
use Illuminate\Support\Facades\Route;



Auth::routes();

// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [PengajuanController::class, 'index']);
Route::get('/data', [PengajuanController::class, 'table']);
Route::post('/ajukan', [PengajuanController::class, 'store']);


