<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Permiso;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CargoController extends Controller
{
    /**
     * Muestra el listado de cargos.
     * Ordenamos DESC (Descendente) para que el Rector (100) aparezca primero.
     */
    public function index()
    {
        $cargos = Cargo::withCount('permisos')
            ->orderBy('nivel_jerarquico', 'desc') // 100 arriba, 0 abajo
            ->get();

        return view('seguridad.cargos.index', compact('cargos'));
    }

    public function create()
    {
        $todosLosPermisos = Permiso::orderBy('Nombrepermiso')->get();
        return view('seguridad.cargos.create', compact('todosLosPermisos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nombrecargo'      => 'required|unique:Cargo,Nombrecargo|max:100',
            
            // VALIDACIÓN 0-100 (El candado del servidor)
            'nivel_jerarquico' => 'required|integer|min:0|max:100',
            
            'permisos'         => 'array'
        ], [
            // Mensajes personalizados para "Hackers"
            'nivel_jerarquico.max' => 'La jerarquía no puede superar el nivel 100 (Rectorado).',
            'nivel_jerarquico.min' => 'El nivel jerárquico no puede ser negativo.'
        ]);

        DB::transaction(function () use ($request) {
            $cargo = Cargo::create([
                'Nombrecargo'      => $request->Nombrecargo,
                'nivel_jerarquico' => $request->nivel_jerarquico
            ]);

            if ($request->has('permisos')) {
                $cargo->permisos()->sync($request->permisos);
            }

            Bitacora::registrar('crear_cargo', "Se creó el cargo: {$cargo->Nombrecargo} (Nivel {$cargo->nivel_jerarquico}).");
        });

        return redirect()->route('cargos.index')->with('success', 'Cargo configurado correctamente.');
    }

    public function edit($id)
    {
        $cargo = Cargo::with('permisos')->findOrFail($id);
        $todosLosPermisos = Permiso::orderBy('Nombrepermiso')->get();

        return view('seguridad.cargos.edit', compact('cargo', 'todosLosPermisos'));
    }

    public function update(Request $request, $id)
    {
        $cargo = Cargo::findOrFail($id);

        $request->validate([
            'Nombrecargo'      => "required|unique:Cargo,Nombrecargo,{$id},CargoID",
            
            // VALIDACIÓN 0-100 EN EDICIÓN TAMBIÉN
            'nivel_jerarquico' => 'required|integer|min:0|max:100',
            
            'permisos'         => 'array'
        ], [
            'nivel_jerarquico.max' => 'La jerarquía no puede superar el nivel 100 (Rectorado).',
            'nivel_jerarquico.min' => 'El nivel jerárquico no puede ser negativo.'
        ]);

        DB::transaction(function () use ($request, $cargo) {
            $cargo->update([
                'Nombrecargo'      => $request->Nombrecargo,
                'nivel_jerarquico' => $request->nivel_jerarquico
            ]);

            $cargo->permisos()->sync($request->permisos ?? []);

            Bitacora::registrar('actualizar_matriz_permisos', "Se actualizó el cargo: {$cargo->Nombrecargo} a nivel {$cargo->nivel_jerarquico}.");
        });

        return redirect()->route('cargos.index')->with('success', 'Configuración de cargo actualizada.');
    }
}