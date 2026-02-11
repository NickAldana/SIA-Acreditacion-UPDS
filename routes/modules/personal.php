<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\CargaAcademicaController;
use App\Http\Controllers\FormacionController;
use App\Http\Controllers\ProfileController;

// =========================================================================
// MÓDULO DE PERSONAL Y RRHH - SIA
// =========================================================================

// --- 1. GESTIÓN DE PERFIL (Usuario Autenticado) ---
Route::controller(ProfileController::class)->group(function () {
    Route::get('/perfil/edit', 'edit')->name('profile.edit');
    Route::put('/perfil/update', 'update')->name('profile.update');
});

// --- 2. GESTIÓN DE PERSONAL (Administración) ---
Route::controller(PersonalController::class)->group(function () {
    
    // Rutas Estáticas (Prioridad)
    Route::get('/personal/reporte-general', 'report')->name('personal.report'); 
    Route::get('/personal', 'index')->name('personal.index');
    Route::get('/personal/crear', 'create')->name('personal.create'); 
    Route::post('/personal', 'store')->name('personal.store');

    // Rutas con Parámetros (ID)
    Route::group(['prefix' => 'personal/{id}', 'where' => ['id' => '[0-9]+']], function () {
        Route::get('/', 'show')->name('personal.show');
        Route::get('/editar', 'edit')->name('personal.edit');
        Route::put('/', 'update')->name('personal.update');
        Route::post('/toggle', 'toggleStatus')->name('personal.toggle');
        Route::get('/imprimir', 'printInformacion')->name('personal.print');
    });
});

// --- 3. CARGA ACADÉMICA Y FORMACIÓN ---
Route::controller(CargaAcademicaController::class)->group(function () {
    Route::get('/carga/asignar', 'create')->name('carga.create');
    Route::post('/carga', 'store')->name('carga.store');
});

Route::controller(FormacionController::class)->group(function () {
    Route::post('/formacion', 'store')->name('formacion.store');
    Route::post('/formacion/actualizar-pdf', 'updatePDF')->name('formacion.updatePDF');
});