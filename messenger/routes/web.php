<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PembayaranController;

Route::get('/notifikasi', [NotifikasiController::class, 'index']);
Route::get('/pembayaran', [PembayaranController::class, 'index']);