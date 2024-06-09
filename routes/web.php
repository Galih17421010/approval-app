<?php

use App\Http\Controllers\PengajuanController;
use Illuminate\Support\Facades\Route;



Auth::routes();

// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [PengajuanController::class, 'index']);
Route::get('/data', [PengajuanController::class, 'table']);
Route::post('/ajukan', [PengajuanController::class, 'store']);
Route::get('/edit/{id}', [PengajuanController::class, 'edit']);
Route::put('/update/{id}', [PengajuanController::class, 'update']);
Route::delete('/delete/{id}', [PengajuanController::class, 'destroy']);


