<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistema SIA (Acreditación UPDS)
|--------------------------------------------------------------------------
*/

// --- PÚBLICO / LOGIN ---
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : view('welcome');
})->name('welcome');

Route::middleware('guest')->controller(AuthController::class)->group(function() {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
});

// --- SISTEMA (Rutas Protegidas) ---
Route::middleware(['auth'])->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /**
     * MÓDULOS AUTOMÁTICOS
     * Los archivos en routes/modules/*.php se cargan solos:
     * - personal.php
     * - investigacion.php
     * - analitica.php
     * - debug.php
     */
});