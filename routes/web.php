<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\SaldoController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('productos', ProductosController::class);
Route::post('productos/{id}/update', [ProductosController::class, 'update'])->name('productos.update.post');

Route::middleware('auth')->group(function () {
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::delete('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::post('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');
    Route::post('/carrito/finalizar', [CarritoController::class, 'finalizar'])->name('carrito.finalizar');
    Route::get('/carrito/resumen', [CarritoController::class, 'resumen'])->name('carrito.resumen');
});

Route::middleware('auth')->group(function () {
    Route::get('/saldo', [SaldoController::class, 'index'])->name('saldo.index');
    Route::post('/saldo/{user}', [SaldoController::class, 'asignar'])->name('saldo.asignar');
});

Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');

Route::post('/carrito/reducir/{id}', [CarritoController::class, 'reducir'])->name('carrito.reducir');

Auth::routes();