<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\{DB, Storage};
use Barryvdh\DomPDF\Facade\Pdf; 
use App\Models\{Publicacion, Tipopublicacion, Mediopublicacion, Rol, Lineainvestigacion, Proyectoinvestigacion, Personal, Carrera};

class PublicacionController extends Controller
{
    /**
     * Listado de Publicaciones (Index)
     */
    public function index(Request $request)
    {
        $request->validate([
            'q' => 'nullable|string|max:100',
            'carrera' => 'nullable|exists:Carrera,CarreraID',
            'tipo' => 'nullable|exists:Tipopublicacion,TipopublicacionID',
            'fecha_desde' => 'nullable|date',
            'fecha_hasta' => 'nullable|date|after_or_equal:fecha_desde',
        ], [
            'fecha_hasta.after_or_equal' => 'La fecha final no puede ser anterior a la fecha inicial.'
        ]);

        $query = $request->get('q');
        $carreraId = $request->get('carrera');
        $tipoId = $request->get('tipo');
        $fDesde = $request->get('fecha_desde');
        $fHasta = $request->get('fecha_hasta');

        $publicaciones = Publicacion::with(['tipo', 'medio', 'autores', 'proyecto.carrera', 'linea'])
            ->when($query, function($q) use ($query) { 
                return $q->where('Nombrepublicacion', 'LIKE', "%$query%"); 
            })
            ->when($carreraId, function($q) use ($carreraId) {
                return $q->whereHas('proyecto', function($p) use ($carreraId) { 
                    $p->where('CarreraID', $carreraId); 
                });
            })
            ->when($tipoId, function($q) use ($tipoId) { 
                return $q->where('TipopublicacionID', $tipoId); 
            })
            ->when($fDesde, function($q) use ($fDesde) { 
                return $q->whereDate('Fechapublicacion', '>=', $fDesde); 
            })
            ->when($fHasta, function($q) use ($fHasta) { 
                return $q->whereDate('Fechapublicacion', '<=', $fHasta); 
            })
            ->orderBy('Fechapublicacion', 'desc')
            ->paginate(15)
            ->appends($request->all());

        $carreras = Carrera::orderBy('Nombrecarrera')->get();
        $tipos = Tipopublicacion::orderBy('Nombretipo')->get();

        return view('publicaciones.index', compact('publicaciones', 'query', 'carreras', 'tipos'));
    }

    /**
     * Formulario de Creación
     */
    public function create()
    {
        $tipos = Tipopublicacion::all();
        $medios = Mediopublicacion::all();
        $roles = Rol::all(); 
        $lineas = Lineainvestigacion::with('facultad')->orderBy('Nombrelineainvestigacion')->get();
        $personales = Personal::where('Activo', 1)->orderBy('Apellidopaterno')->get(); 

        $proyectos = Proyectoinvestigacion::with(['linea', 'equipo'])
            ->where('Estado', 'En Ejecución')
            ->orderBy('Nombreproyecto')
            ->get();

        return view('publicaciones.create', compact('tipos', 'medios', 'roles', 'proyectos', 'personales', 'lineas'));
    }

    /**
     * Guardar Publicación
     */
    public function store(Request $request)
    {
        $request->validate([
            'Nombrepublicacion' => 'required|string|min:10|max:500',
            'Fechapublicacion' => 'required|date|before_or_equal:today',
            'LineainvestigacionID' => 'required|exists:Lineainvestigacion,LineainvestigacionID',
            'MediopublicacionID' => 'required',
            'archivo_evidencia' => 'nullable|file|mimes:pdf|max:10240',
            'UrlPublicacion' => 'nullable|url',
            'autores' => 'required|array|min:1',
        ], [
            'Fechapublicacion.before_or_equal' => 'No se pueden registrar publicaciones con fechas futuras.',
            'archivo_evidencia.mimes' => 'El archivo de respaldo debe ser obligatoriamente un PDF.'
        ]);

        DB::beginTransaction();
        try {
            $publicacion = Publicacion::create(array_merge($request->all(), [
                'Nombrepublicacion' => Str::upper($request->Nombrepublicacion)
            ]));

            if ($request->hasFile('archivo_evidencia')) {
                $ruta = $request->file('archivo_evidencia')->store('evidencias_publicaciones', 'public');
                $publicacion->update(['RutaArchivo' => $ruta]);
            }

            $syncData = [];
            foreach ($request->autores as $index => $idPersonal) {
                if (empty($idPersonal)) continue;
                $syncData[$idPersonal] = [
                    'RolID' => $request->roles[$index] ?? 1 
                ];
            }
            $publicacion->autores()->sync($syncData);

            DB::commit();
            return redirect()->route('publicaciones.index')->with('success', 'Publicación registrada y vinculada correctamente.');

        } catch (\Exception $e) { 
            DB::rollBack(); 
            return back()->with('error', 'Error en el registro: ' . $e->getMessage())->withInput(); 
        }
    }

    /**
     * Formulario de Edición
     */
    public function edit($id)
    {
        $publicacion = Publicacion::with('autores')->findOrFail($id);
        $tipos = Tipopublicacion::all();
        $medios = Mediopublicacion::all();
        $roles = Rol::all();
        $lineas = Lineainvestigacion::all();
        $proyectos = Proyectoinvestigacion::where('Estado', 'En Ejecución')->get();
        $personales = Personal::where('Activo', 1)->orderBy('Apellidopaterno')->get();

        return view('publicaciones.edit', compact('publicacion', 'tipos', 'medios', 'roles', 'proyectos', 'personales', 'lineas'));
    }

    /**
     * Actualizar Publicación
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Nombrepublicacion' => 'required|min:10',
            'Fechapublicacion' => 'required|date|before_or_equal:today',
        ]);

        DB::beginTransaction();
        try {
            $publicacion = Publicacion::findOrFail($id);
            $publicacion->update(array_merge($request->all(), [
                'Nombrepublicacion' => Str::upper($request->Nombrepublicacion)
            ]));

            if ($request->hasFile('archivo_evidencia')) {
                $publicacion->update(['RutaArchivo' => $request->file('archivo_evidencia')->store('evidencias', 'public')]);
            }

            $syncData = [];
            foreach ($request->autores as $i => $idp) { 
                if(!empty($idp)) {
                    $syncData[$idp] = ['RolID' => $request->roles[$i] ?? 1]; 
                }
            }
            $publicacion->autores()->sync($syncData);

            DB::commit();
            return redirect()->route('publicaciones.index')->with('success', 'Registro actualizado con éxito.');
        } catch (\Exception $e) { 
            DB::rollBack(); 
            return back()->with('error', $e->getMessage()); 
        }
    }

    /**
     * Generar PDF de Publicaciones
     */
    public function reportePDF(Request $request) 
    {
        $publicaciones = Publicacion::with(['tipo', 'autores', 'proyecto.carrera', 'linea', 'medio'])
            ->when($request->q, function($q) use ($request) { 
                return $q->where('Nombrepublicacion', 'LIKE', "%{$request->q}%"); 
            })
            ->when($request->carrera, function($q) use ($request) {
                return $q->whereHas('proyecto', function($p) use ($request) { 
                    $p->where('CarreraID', $request->carrera); 
                });
            })
            ->when($request->tipo, function($q) use ($request) { 
                return $q->where('TipopublicacionID', $request->tipo); 
            })
            ->orderBy('Fechapublicacion', 'desc')
            ->get();

        $pdf = Pdf::loadView('publicaciones.pdf_publicacion', compact('publicaciones'));
        
        return $pdf->setPaper('letter', 'portrait')
                ->stream('Kardex_Produccion_Cientifica_' . date('Ymd') . '.pdf');
    }
}