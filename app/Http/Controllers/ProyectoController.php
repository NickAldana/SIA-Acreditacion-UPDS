<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf; 
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\{DB, Auth};
use App\Models\{Proyectoinvestigacion, Personal, Carrera, Lineainvestigacion};

class ProyectoController extends Controller
{
    // =========================================================================
    // HELPER INTERNO
    // =========================================================================
    private function traducirRol($codigo) {
        return match ($codigo) {
            '1' => 'ENCARGADO DE PROYECTO',
            '2' => 'DOCENTE INVESTIGADOR',
            '3' => 'ESTUDIANTE INVESTIGADOR',
            '4' => 'PASANTE',
            '5' => 'REVISOR TÉCNICO',
            '6' => 'TUTOR / ASESOR',
            default => $codigo, 
        };
    }

    // =========================================================================
    // 1. LISTADO (INDEX)
    // =========================================================================
    public function index(Request $request)
    {
        $request->validate([
            'fecha_desde' => 'nullable|date',
            'fecha_hasta' => 'nullable|date|after_or_equal:fecha_desde',
            'estado'      => 'nullable|in:En Ejecución,Planificado,Finalizado,Cancelado',
        ]);

        $busqueda = $request->get('q');
        $filtroEstado = $request->get('estado');
        $filtroCarrera = $request->get('carrera');
        
        $proyectos = Proyectoinvestigacion::with(['carrera', 'linea', 'equipo']) 
            ->when($busqueda, function($query) use ($busqueda) {
                return $query->where(function($q) use ($busqueda) {
                    $q->where('Nombreproyecto', 'LIKE', "%$busqueda%")
                      ->orWhere('CodigoProyecto', 'LIKE', "%$busqueda%");
                });
            })
            ->when($filtroEstado, function($q) use ($filtroEstado) { 
                return $q->where('Estado', $filtroEstado); 
            })
            ->when($filtroCarrera, function($q) use ($filtroCarrera) { 
                return $q->where('CarreraID', $filtroCarrera); 
            })
            ->when($request->fecha_desde, function($q) use ($request) { 
                return $q->whereDate('Fechainicio', '>=', $request->fecha_desde); 
            })
            ->when($request->fecha_hasta, function($q) use ($request) { 
                return $q->whereDate('Fechainicio', '<=', $request->fecha_hasta); 
            })
            ->orderBy('Fechainicio', 'desc')
            ->orderBy('ProyectoinvestigacionID', 'desc')
            ->paginate(10)
            ->appends($request->all());

        // Datos para los filtros de la vista
        $carreras = Carrera::orderBy('Nombrecarrera')->get();
        $personales = Personal::where('Activo', 1)->orderBy('Apellidopaterno')->get();
        
        // CORREGIDO: Apunta a la carpeta 'proyectos'
        return view('proyectos.index', compact(
            'proyectos', 'personales', 'carreras', 'busqueda', 'filtroEstado', 'filtroCarrera'
        ));
    }

    // =========================================================================
    // 2. CREAR (CREATE & STORE)
    // =========================================================================
    public function create()
    {
        $carreras = Carrera::orderBy('Nombrecarrera')->get();
        $personales = Personal::where('Activo', 1)->orderBy('Apellidopaterno')->get();
        $lineas = Lineainvestigacion::with('facultad')->orderBy('Nombrelineainvestigacion')->get();

        // CORREGIDO: Apunta a la carpeta 'proyectos'
        return view('proyectos.create', compact('carreras', 'personales', 'lineas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nombreproyecto' => 'required|min:10',
            'Estado'         => 'required|in:En Ejecución,Planificado,Finalizado,Cancelado',
            'Fechainicio'    => $request->Estado === 'Planificado' 
                                ? 'required|date|after:today' 
                                : 'required|date|before_or_equal:today',
            'participantes'  => 'required|array|min:1',
        ], [
            'Fechainicio.after' => 'Un proyecto planificado debe programarse para una fecha futura.',
            'Fechainicio.before_or_equal' => 'Un proyecto en ejecución no puede tener una fecha de inicio futura.'
        ]);

        DB::beginTransaction();
        try {
            // Generación Automática de Código (INV-2026-001)
            $anioActual = date('Y');
            $ultimoProyecto = Proyectoinvestigacion::where('CodigoProyecto', 'LIKE', "INV-$anioActual-%")
                                            ->orderBy('CodigoProyecto', 'desc')
                                            ->lockForUpdate()->first();

            if ($ultimoProyecto) {
                $partes = explode('-', $ultimoProyecto->CodigoProyecto);
                $ultimoCorrelativo = (int)end($partes);
                $numero = $ultimoCorrelativo + 1;
            } else {
                $numero = 1; 
            }

            $codigoGenerado = "INV-" . $anioActual . "-" . str_pad($numero, 3, '0', STR_PAD_LEFT);

            // Crear Proyecto
            $proyecto = Proyectoinvestigacion::create(array_merge($request->except('CodigoProyecto'), [
                'Nombreproyecto' => Str::upper($request->Nombreproyecto),
                'CodigoProyecto' => $codigoGenerado 
            ]));

            // Asignar Equipo (Evitando duplicados de ID en el array)
            $participantesUnicos = array_unique($request->participantes);
            foreach ($participantesUnicos as $index => $idPersonal) {
                if (empty($idPersonal)) continue;
                
                $proyecto->equipo()->attach($idPersonal, [
                    'Rol'           => $this->traducirRol($request->roles_proy[$index]),
                    'EsResponsable' => isset($request->es_responsable[$index]) ? 1 : 0, 
                    'FechaInicio'   => $request->fechas_inc[$index] ?? $proyecto->Fechainicio, 
                ]);
            }
            
            DB::commit();
            // Nota: Mantenemos la ruta 'investigacion.index' según web.php
            return redirect()->route('investigacion.index')
                             ->with('success', "Proyecto $codigoGenerado registrado correctamente.");

        } catch (\Exception $e) { 
            DB::rollBack(); 
            return back()->with('error', 'Error al registrar: ' . $e->getMessage())->withInput(); 
        }
    }

    // =========================================================================
    // 3. EDITAR (EDIT & UPDATE)
    // =========================================================================
    public function edit($id)
    {
        $proyecto = Proyectoinvestigacion::with('equipo')->findOrFail($id);

        if (in_array($proyecto->Estado, ['Finalizado', 'Cancelado'])) {
            return redirect()->route('investigacion.index')
                ->with('error', 'ACCESO DENEGADO: El proyecto se encuentra cerrado (' . $proyecto->Estado . ').');
        }

        $carreras = Carrera::orderBy('Nombrecarrera')->get();
        $personales = Personal::where('Activo', 1)->orderBy('Apellidopaterno')->get();
        $lineas = Lineainvestigacion::with('facultad')->orderBy('Nombrelineainvestigacion')->get(); 
        
        // CORREGIDO: Apunta a la carpeta 'proyectos'
        return view('proyectos.edit', compact('proyecto', 'carreras', 'personales', 'lineas'));
    }

    public function update(Request $request, $id)
    {
        $proyecto = Proyectoinvestigacion::findOrFail($id);

        if (in_array($proyecto->Estado, ['Finalizado', 'Cancelado'])) {
            return redirect()->route('investigacion.index')
                ->with('error', 'ERROR DE INTEGRIDAD: No se pueden alterar registros históricos cerrados.');
        }

        $request->validate([
            'Nombreproyecto' => 'required|min:10',
            'Estado'         => 'required|in:En Ejecución,Planificado,Finalizado,Cancelado',
            'Fechainicio'    => $request->Estado === 'Planificado' 
                                ? 'required|date|after:today' 
                                : 'required|date|before_or_equal:today',
            'participantes'  => 'required|array|min:1',
        ], [
            'Fechainicio.after' => 'La planificación debe programarse para una fecha futura.',
            'Fechainicio.before_or_equal' => 'Un proyecto vigente no puede iniciar en una fecha futura.'
        ]);

        DB::beginTransaction();
        try {
            $esCierreProyecto = in_array($request->Estado, ['Finalizado', 'Cancelado']);
            $hoy = now()->format('Y-m-d');

            $proyecto->update(array_merge($request->except('CodigoProyecto'), [
                'Nombreproyecto'    => Str::upper($request->Nombreproyecto),
                'Fechafinalizacion' => $esCierreProyecto ? $hoy : null
            ]));

            $proyecto->equipo()->detach();

            foreach ($request->participantes as $i => $idp) {
                if (empty($idp)) continue;

                $fechaFinInput = !empty($request->fechas_fin[$i]) ? $request->fechas_fin[$i] : null;
                $fechaFinFinal = $esCierreProyecto ? ($fechaFinInput ?? $hoy) : $fechaFinInput;
                $fechaInicioFinal = $request->fechas_inc[$i] ?? $proyecto->Fechainicio;

                $proyecto->equipo()->attach($idp, [
                    'Rol'           => $this->traducirRol($request->roles_proy[$i]),
                    'EsResponsable' => isset($request->es_responsable[$i]) ? 1 : 0,
                    'FechaInicio'   => $fechaInicioFinal,
                    'FechaFin'      => $fechaFinFinal
                ]);
            }
            
            DB::commit();
            return redirect()->route('investigacion.index')
                ->with('success', "Expediente del proyecto {$proyecto->CodigoProyecto} actualizado correctamente.");

        } catch (\Exception $e) {
            DB::rollBack();
            if (str_contains($e->getMessage(), 'Duplicate entry') || 
                str_contains($e->getMessage(), 'Violation of PRIMARY KEY') || 
                str_contains($e->getMessage(), 'Violation of UNIQUE KEY')) {
                return back()->with('error', 'ERROR DE BASE DE DATOS: No se puede registrar a la misma persona dos veces en el mismo proyecto.')->withInput();
            }
            return back()->with('error', 'Fallo en la actualización: ' . $e->getMessage())->withInput();
        }
    }

    // =========================================================================
    // 4. DETALLE (SHOW)
    // =========================================================================
    public function show($id)
    {
        $proyecto = Proyectoinvestigacion::with([
            'carrera', 'linea', 'equipo', 'publicaciones.tipo' 
        ])->findOrFail($id);

        $equipoOrdenado = $proyecto->equipo->sort(function($a, $b) {
            if ($a->pivot->EsResponsable && !$b->pivot->EsResponsable) return -1;
            if (!$a->pivot->EsResponsable && $b->pivot->EsResponsable) return 1;
            $aActivo = is_null($a->pivot->FechaFin);
            $bActivo = is_null($b->pivot->FechaFin);
            if ($aActivo && !$bActivo) return -1;
            if (!$aActivo && $bActivo) return 1;
            return 0;
        });

        $proyecto->setRelation('equipo', $equipoOrdenado);

        // CORREGIDO: Apunta a la carpeta 'proyectos'
        return view('proyectos.show', compact('proyecto'));
    }

    // =========================================================================
    // 5. REPORTES PDF
    // =========================================================================
    public function reportePDF(Request $request)
    {
        // CASO A: Reporte Individual
        if ($request->has('id')) {
            $proyecto = Proyectoinvestigacion::with(['carrera', 'linea', 'equipo', 'publicaciones'])
                ->findOrFail($request->id);

            // CORREGIDO: Apunta a la carpeta 'proyectos'
            $pdf = Pdf::loadView('proyectos.reporte_individual', compact('proyecto'));
            return $pdf->setPaper('letter', 'portrait')
                       ->stream('Kardex_'.$proyecto->CodigoProyecto.'.pdf');
        }

        // CASO B: Reporte General
        $proyectos = Proyectoinvestigacion::with(['carrera', 'linea', 'equipo'])
            ->when($request->estado, function($q) use ($request) { 
                return $q->where('Estado', $request->estado); 
            })
            ->when($request->carrera, function($q) use ($request) { 
                return $q->where('CarreraID', $request->carrera); 
            })
            ->orderBy('Fechainicio', 'desc')
            ->get();

        // CORREGIDO: Apunta a la carpeta 'proyectos'
        $pdf = Pdf::loadView('proyectos.pdf_proyectos', compact('proyectos'));
        return $pdf->setPaper('letter', 'landscape')
                   ->download('Cartera_Proyectos_Investigacion.pdf');
    }
}