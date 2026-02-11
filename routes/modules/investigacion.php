<?php

use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\PresupuestoController;
use Illuminate\Support\Facades\Route;

// =========================================================================
// MÓDULO DE INVESTIGACIÓN - SIA
// =========================================================================

// --- 1. GESTIÓN DE PROYECTOS ---
Route::controller(ProyectoController::class)
    ->prefix('investigacion')          
    ->name('investigacion.')           
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/reporte-proyectos', 'reportePDF')->name('pdf_proyectos');
        Route::get('/crear', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show')->whereNumber('id');
        Route::get('/{id}/editar', 'edit')->name('edit')->whereNumber('id');
        Route::put('/{id}', 'update')->name('update')->whereNumber('id');
    });

// --- 2. GESTIÓN DE PUBLICACIONES ---
Route::controller(PublicacionController::class)
    ->prefix('publicaciones')          
    ->name('publicaciones.')           
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/reporte-general', 'reportePDF')->name('pdf');
        Route::get('/crear', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/editar', 'edit')->name('edit')->whereNumber('id');
        Route::put('/{id}', 'update')->name('update')->whereNumber('id');
    });

// --- 3. GESTIÓN FINANCIERA (PRESUPUESTO) ---
Route::controller(PresupuestoController::class)
    ->prefix('investigacion/proyecto/{proyectoId}/presupuesto') 
    ->name('presupuesto.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/registrar', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/reporte-pdf', 'reportePDF')->name('reporte_pdf');
        Route::post('/{id}/validar', 'toggleValidacion')->name('toggle'); 
        Route::delete('/{id}', 'destroy')->name('destroy');
    })->whereNumber(['proyectoId', 'id']);