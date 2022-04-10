<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ResepController;
use App\Http\Controllers\ObatalkesController;
use App\Http\Controllers\SignaController;
use App\Http\Controllers\RacikanController;

Route::get('/', [ResepController::class, 'index']);
Route::get('/obat', [ObatalkesController::class, 'index']);

// racikan controller
Route::get('/obat-racikan', [RacikanController::class, 'index']);
Route::post('/obat-racikan-create', [RacikanController::class, 'create']);
Route::get('/tabel-racikan', [RacikanController::class, 'tabel_racikan']);
Route::get('/data-tabel-racikan', [RacikanController::class, 'data_tabel_racikan']);
Route::get('/komposisi-racikan', [RacikanController::class, 'komposisi_racikan']);
Route::post('/komposisi-create', [RacikanController::class, 'komposisi_create']);
Route::delete('/racikan-delete', [RacikanController::class, 'racikan_delete']);
Route::delete('/racikan-delete', [RacikanController::class, 'racikan_delete']);
Route::post('/komposisi-racikan-create', [RacikanController::class, 'komposisi_racikan_create']);
Route::get('/data-tabel-komposisi', [RacikanController::class, 'data_tabel_komposisi']);
Route::delete('/racikan-komposisi-delete', [RacikanController::class, 'racikan_komposisi_delete']);

// resep controller
Route::get('/get-signa-racikan', [ResepController::class, 'get_signa_racikan']);
Route::post('/simpan-detail-resep', [ResepController::class, 'simpan_detail_resep']);
Route::post('/simpan-resep', [ResepController::class, 'simpan_resep']);
Route::get('/data-tabel-resep', [ResepController::class, 'data_tabel_resep']);
Route::get('/edit-resep', [ResepController::class, 'edit_resep']);
Route::get('/data-tabel-resep-detail', [ResepController::class, 'data_tabel_resep_detail']);
Route::delete('/hapus-resep-detail', [ResepController::class, 'hapus_resep_detail']);
Route::delete('/hapus-resep', [ResepController::class, 'hapus_resep']);
Route::get('/print-resep', [ResepController::class, 'print_resep']);