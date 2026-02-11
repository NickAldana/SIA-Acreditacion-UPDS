<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// =========================================================================
// MÓDULO DE DIAGNÓSTICO Y DEBUG - SIA
// =========================================================================

Route::get('/test-permisos', function () {
    /** @var \App\Models\Usuario $user */
    $user = Auth::user();
    
    if (!$user) {
        return response()->json(['status' => 'error', 'message' => 'No has iniciado sesión'], 401);
    }
    
    // Carga de relaciones para el diagnóstico
    $personal = $user->personal;
    $cargo = $personal ? $personal->cargo : null;
    $permisos = $cargo ? $cargo->permisos : collect([]);

    return response()->json([
        'info_usuario' => [
            'id' => $user->UsuarioID,
            'nombre' => $user->NombreUsuario,
            'personal' => $personal ? $personal->Nombrecompleto : 'NINGUNO',
            'cargo' => $cargo ? $cargo->Nombrecargo : 'SIN CARGO'
        ],
        'permisos_bd' => [
            'total' => $permisos->count(),
            'lista' => $permisos->pluck('Nombrepermiso')
        ],
        'validacion_logic' => [
            'acceso_total' => $user->canDo('acceso_total') ? '✅' : '❌',
            'ver_dashboard_bi' => $user->canDo('ver_dashboard_bi') ? '✅' : '❌',
            'gestion_personal' => $user->canDo('gestion_personal') ? '✅' : '❌',
            'gestion_academica' => $user->canDo('gestion_academica') ? '✅' : '❌',
        ]
    ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
})->name('debug.permisos');