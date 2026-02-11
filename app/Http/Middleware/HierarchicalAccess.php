<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bitacora;

class HierarchicalAccess
{
    /**
     * Maneja la restricción de acceso por nivel jerárquico.
     * $nivelRequerido es el nivel máximo permitido para la ruta (ej: 3).
     */
    public function handle(Request $request, Closure $next, $nivelRequerido)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Accedemos al nivel: Usuario -> Personal -> Cargo -> nivel_jerarquico
        $nivelUsuario = Auth::user()->personal->cargo->nivel_jerarquico ?? 99;

        // Lógica: Si el nivel del usuario es menor o igual al requerido (Ej: 2 <= 3)
        if ($nivelUsuario <= (int)$nivelRequerido) {
            return $next($request);
        }

        // Registro de auditoría por intento de acceso no autorizado
        Bitacora::registrar('ACCESO_DENEGADO', "Ruta nivel {$nivelRequerido} bloqueada para usuario nivel {$nivelUsuario}");

        abort(403, 'No tienes el rango administrativo suficiente para esta sección.');
    }
}