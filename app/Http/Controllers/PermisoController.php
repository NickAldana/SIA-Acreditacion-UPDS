<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Importante para formatear el slug
use Illuminate\Support\Facades\DB;

class PermisoController extends Controller
{
    /**
     * Listado de todos los permisos registrados en el sistema.
     * Se ordenan alfabéticamente para facilitar la búsqueda en la Matriz.
     */
    public function index()
    {
        $permisos = Permiso::orderBy('Nombrepermiso', 'asc')->get();
        return view('seguridad.permisos.index', compact('permisos'));
    }

    /**
     * Registra un nuevo permiso técnico (Granular).
     * Ejemplo: 'ver_datos_sensibles'
     */
    public function store(Request $request)
    {
        // 1. Sanitización previa (Limpieza de entrada)
        // Convertimos "Ver Datos Sensibles" -> "ver_datos_sensibles" antes de validar
        $request->merge([
            'Nombrepermiso' => Str::slug($request->Nombrepermiso, '_')
        ]);

        // 2. Validaciones Robustas
        $request->validate([
            'Nombrepermiso' => [
                'required',
                'unique:Permisos,Nombrepermiso',
                'max:60',
                'regex:/^[a-z0-9_]+$/' // Solo minúsculas, números y guion bajo
            ],
            'Descripcion' => 'required|string|max:150' // Obligatorio para que el diccionario sea útil
        ], [
            'Nombrepermiso.unique'   => 'Este nombre técnico ya existe. Intenta con otro.',
            'Nombrepermiso.regex'    => 'El permiso solo debe contener letras minúsculas y guiones bajos (_).',
            'Descripcion.required'   => 'Por favor describe qué hace este permiso (para la auditoría).'
        ]);

        try {
            DB::beginTransaction();

            // 3. Creación del Permiso
            $permiso = Permiso::create([
                'Nombrepermiso' => $request->Nombrepermiso,
                'Descripcion'   => ucfirst($request->Descripcion) // Primera letra mayúscula por estética
            ]);

            // 4. Registro en Bitácora (Seguridad)
            Bitacora::registrar(
                'crear_permiso_seguridad', 
                "Se registró el permiso técnico: {$permiso->Nombrepermiso} ({$permiso->Descripcion})"
            );

            DB::commit();

            return back()->with('success', "Permiso '{$permiso->Nombrepermiso}' registrado exitosamente.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al registrar el permiso: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar un permiso (Solo si se creó por error y no está en uso crítico).
     * Opcional pero recomendado para mantenimiento.
     */
public function destroy($id)
    {
        $permiso = Permiso::findOrFail($id);

        // PROTECCIÓN 1: No borrar permisos críticos (Hardcoded)
        $protegidos = ['acceso_total', 'ver_perfil_propio'];
        if (in_array($permiso->Nombrepermiso, $protegidos)) {
            return back()->with('error', '¡Alto ahí! Este permiso es vital para el sistema.');
        }

        // SOLUCIÓN AL ERROR 1451:
        // Primero "despegamos" el permiso de todos los cargos (limpia la tabla pivote Cargopermiso)
        $permiso->cargos()->detach(); 

        // Ahora que está suelto, lo borramos sin problemas
        $permiso->delete();
        
        Bitacora::registrar('eliminar_permiso', "Se eliminó el permiso: {$permiso->Nombrepermiso}");

        return back()->with('success', 'Permiso eliminado correctamente (y desvinculado de los cargos).');
    }
}