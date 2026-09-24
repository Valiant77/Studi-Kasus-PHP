<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;

Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
Route::get('/karyawan/{nip}', [KaryawanController::class, 'show'])->name('karyawan.show');
Route::get('/karyawan/laporan/gaji', [KaryawanController::class, 'laporanGaji'])->name('karyawan.gaji');
Route::redirect('/', '/karyawan');