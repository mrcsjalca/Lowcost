<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('productos', ProductosController::class);
Route::post('productos/{id}/update', [ProductosController::class, 'update'])->name('productos.update.post');

Auth::routes();