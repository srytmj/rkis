<?php

use App\Http\Controllers\KasController;
use App\Http\Controllers\AkunController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard.index');
});


// Route::get('/dashboard', [KasController::class, 'index'])->name('dashboard');

Route::resource('/dashboard', KasController::class);

Route::resource('/akun', AkunController::class);

// Route untuk laporan
Route::get('/jurnal/umum', [App\Http\Controllers\JurnalController::class,'jurnalumum'])->name('jurnalumum');
Route::get('/jurnal/umum/fetch', [App\Http\Controllers\JurnalController::class, 'fetchJurnal'])->name('jurnal.fetch');
Route::get('/jurnal/buku-besar', [App\Http\Controllers\JurnalController::class, 'bukubesar'])->name('bukubesar');
Route::get('/jurnal/buku-besar/fetch', [App\Http\Controllers\JurnalController::class, 'fetchBukbes'])->name('jurnal.bukbes');
