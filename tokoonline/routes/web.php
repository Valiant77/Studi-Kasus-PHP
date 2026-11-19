<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RestoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/produk', [ProdukController::class, 'index'])->name('produk');
Route::get('/resto', [RestoController::class, 'index'])->name('resto');
Route::post('/resto/{id}', [RestoController::class, 'change'])->name('change');