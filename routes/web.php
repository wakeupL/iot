<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\ListaPedidos;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IngresoMaterialController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\PedidosController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('bodega', function () {
        return view('bodega');})->name('bodega');

    Route::get('ingreso-material', [IngresoMaterialController::class, 'index'])->name('ingreso-material.index');
    Route::post('registrar-pedido', [PedidosController::class, 'registrarPedido'])->name('pedido.registrar');
    Route::get('separar-pedido/{id}', [PedidosController::class, 'prepararPedido'])->name('pedido.preparar');
    Route::get('pedidos', ListaPedidos::class)->name('pedidos.index');

    });

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
