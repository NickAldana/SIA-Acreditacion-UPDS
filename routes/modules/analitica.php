<?php

use Illuminate\Support\Facades\Route;

// --- ANALÍTICA ---
Route::view('/analitica/acreditacion', 'analitica.acreditacion')->name('analitica.acreditacion');

// --- VISOR DE REPORTES ---
Route::get('/analitica/reporte/{archivo}', function ($archivo) {
    return view('analitica.visor-pdf', [
        'archivo' => $archivo, 
        'titulo' => 'Documento del Sistema'
    ]);
})->name('reporte.pdf')->where('archivo', '.*');