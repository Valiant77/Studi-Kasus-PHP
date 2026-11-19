<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/sekolah', [SchoolController::class, 'index'])->name('sekolah');
Route::post('/sekolah', [SchoolController::class, 'store'])->name('sekolah.store');
Route::put('/sekolah/{school}', [SchoolController::class, 'update'])->name('sekolah.update');
Route::delete('/sekolah/{school}', [SchoolController::class, 'destroy'])->name('sekolah.destroy');
Route::get('/siswa', [StudentController::class, 'index'])->name('siswa');
Route::post('/siswa', [StudentController::class, 'store'])->name('siswa.store');
Route::put('/siswa/{student}', [StudentController::class, 'update'])->name('siswa.update');
Route::delete('/siswa/{student}', [StudentController::class, 'destroy'])->name('siswa.destroy');