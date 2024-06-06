<?php

use App\Http\Controllers\PengajuanController;
use Illuminate\Support\Facades\Route;



Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/pengajuan', [PengajuanController::class, 'index']);

Route::get('/login2', function(){
    return view('login2');
});