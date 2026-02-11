<?php

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\PermisoController;
use Illuminate\Support\Facades\Route;

/**
 * MÓDULO 1: SEGURIDAD Y USUARIOS (CORE)
 * Rutas protegidas por el middleware 'auth' definido en AppServiceProvider
 */

// 1. Gestión de Cuentas (SEG-02)
Route::controller(UsuarioController::class)->prefix('usuarios')->name('usuarios.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{id}/editar', 'edit')->name('edit');
    Route::put('/{id}', 'update')->name('update');
    Route::post('/{id}/reset-password', 'resetPassword')->name('reset');
    Route::post('/{id}/toggle', 'toggleStatus')->name('toggle');
});

// 2. Gestión de Roles y Matriz de Permisos (SEG-03 / SEG-04)
Route::resource('cargos', CargoController::class)->except(['show', 'destroy']);

// 3. Gestión de Permisos Globales (Escalabilidad)
Route::get('permisos', [PermisoController::class, 'index'])->name('permisos.index');
Route::post('permisos', [PermisoController::class, 'store'])->name('permisos.store');
Route::delete('permisos/{id}', [PermisoController::class, 'destroy'])->name('permisos.destroy');