<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\Personal;
use App\Models\Materia;

class CargaAcademicaController extends Controller
{
    /**
     * Muestra la pantalla de asignación con datos precargados.
     */
    public function create(Request $request)
    {
        // 1. SEGURIDAD
        if (!Gate::allows('gestion_academica') && !Gate::allows('acceso_total')) {
            abort(403, 'Requiere permisos de Gestión Académica.');
        }

        // 2. OBTENER DOCENTES
        // Solo activos, ordenados y con su cargo
        $docentes = Personal::where('Activo', 1)
            ->select('PersonalID', 'Nombrecompleto', 'Apellidopaterno', 'Apellidomaterno', 'Fotoperfil', 'CargoID')
            ->with('cargo:CargoID,Nombrecargo')
            ->orderBy('Apellidopaterno')
            ->orderBy('Apellidomaterno')
            ->get();

        // 3. OBTENER MATERIAS
        // Preparamos el string de carreras para el buscador JS
        $materias = Materia::with('carreras:CarreraID,Nombrecarrera')
            ->select('MateriaID', 'Sigla', 'Nombremateria')
            ->orderBy('Nombremateria')
            ->get()
            ->map(function ($materia) {
                $materia->nombres_carreras = $materia->carreras->isNotEmpty() 
                    ? $materia->carreras->pluck('Nombrecarrera')->join(', ') 
                    : 'Transversal';
                return $materia;
            });

        // 4. LÓGICA DE GRUPO INTELIGENTE (Auto-Incremento A -> B -> C)
        $materia_id = $request->input('MateriaID');
        $periodo_actual = $request->input('Periodo', 1); // Por defecto Semestre 1
        $gestion_actual = date('Y');
        $siguienteGrupo = 'A'; // Valor inicial por defecto
        
        if ($materia_id) {
            // Buscamos cuál es la letra más alta asignada en esta gestión/periodo
            $ultimoGrupo = DB::table('Personalmateria')
                ->where('MateriaID', $materia_id)
                ->where('Gestion', $gestion_actual)
                ->where('Periodo', $periodo_actual)
                ->max('Grupo'); // Ej: Si existe 'A', retorna 'A'

            // Si existe un grupo previo, calculamos el siguiente (A -> B)
            if ($ultimoGrupo) {
                $siguienteGrupo = ++$ultimoGrupo; 
            }
        }

        return view('carga.create', [
            'docentes' => $docentes,
            'materias' => $materias,
            'materia_id' => $materia_id,
            'siguienteGrupo' => $siguienteGrupo, // Enviamos la sugerencia a la vista
            'docente_id' => $request->input('docente_id')
        ]);
    }

    /**
     * Guarda la asignación en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. VALIDACIÓN
        $request->validate([
            'PersonalID' => 'required|exists:Personal,PersonalID',
            'MateriaID'  => 'required|exists:Materia,MateriaID',
            'Gestion'    => 'required|integer',
            'Periodo'    => 'required',
            'Grupo'      => 'required|string|max:10',
            // Validamos las modalidades permitidas en acreditación
            'Modalidad'  => 'required|in:Presencial,Virtual,Semipresencial', 
        ]);

        $grupo = strtoupper(trim($request->Grupo));

        try {
            DB::transaction(function () use ($request, $grupo) {
                
                // 2. VERIFICACIÓN DE CONFLICTO (Regla de Oro)
                // No puede haber dos docentes con el mismo Grupo en la misma Materia/Periodo.
                $ocupante = DB::table('Personalmateria')
                    ->where('MateriaID', $request->MateriaID)
                    ->where('Gestion', $request->Gestion)
                    ->where('Periodo', $request->Periodo)
                    ->where('Grupo', $grupo)
                    ->first();

                if ($ocupante) {
                    // Si ya existe, obtenemos el nombre del "dueño" del grupo
                    $docente = Personal::find($ocupante->PersonalID);
                    $nombre = $docente ? $docente->Nombrecompleto : 'Otro docente';
                    
                    throw new \Exception("Conflicto: El Grupo '$grupo' de esta materia ya está asignado a $nombre. Por favor seleccione el siguiente grupo.");
                }

                // 3. INSERTAR ASIGNACIÓN
                DB::table('Personalmateria')->insert([
                    'PersonalID' => $request->PersonalID,
                    'MateriaID'  => $request->MateriaID,
                    'Gestion'    => $request->Gestion,
                    'Periodo'    => $request->Periodo,
                    'Grupo'      => $grupo,
                    'Modalidad'  => $request->Modalidad,
                    // Los campos de evaluación (Ruta, Nota) quedan NULL hasta fin de semestre
                ]);
            });

            // 4. REDIRECCIÓN FLUIDA
            // Volvemos a la pantalla 'create' pasando los parámetros para que
            // el usuario siga trabajando en la misma materia (ej: para crear el Grupo B).
            return redirect()
                ->route('carga.create', [
                    'MateriaID' => $request->MateriaID, 
                    'Periodo' => $request->Periodo 
                ])
                ->with('success', "¡Asignación exitosa! Docente registrado en el Grupo $grupo ($request->Modalidad).");

        } catch (\Exception $e) {
            // Si hay error, volvemos atrás manteniendo los datos del formulario
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}