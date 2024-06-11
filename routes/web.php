<?php

use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ManagerController;
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
Route::get('/detail/{id}', [PengajuanController::class, 'detail']);

Route::post('/approve/{id}', [ManagerController::class, 'store']);
Route::post('/reject/{id}', [ManagerController::class, 'reject']);

Route::post('/finance-approve/{id}', [FinanceController::class, 'store']);
Route::post('/finance-reject/{id}', [FinanceController::class, 'reject']);
Route::post('/finance-upload/{id}', [FinanceController::class, 'upload']);


