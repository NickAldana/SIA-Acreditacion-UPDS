<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

// MODELOS V6
use App\Models\Personal;
use App\Models\Materia;
use App\Models\User; // Tu modelo de Auth (Tabla Usuario)
use App\Models\Proyectoinvestigacion;
use App\Models\Tipocontrato;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $gestionActual = 2026;

        // ---------------------------------------------------------------------
        // 1. LÓGICA PARA ADMINISTRADORES / GESTORES
        // ---------------------------------------------------------------------
        if ($user->canDo('gestionar_personal')) {
            
            $cacheKey = $user->canDo('acceso_total') 
                ? 'dashboard_stats_global' 
                : 'dashboard_stats_user_' . $user->UsuarioID; // V6: UsuarioID

            $stats = Cache::remember($cacheKey, 60, function () use ($user, $gestionActual) {
                $query = Personal::query();

                // SEGURIDAD HORIZONTAL (Visión de Túnel V6)
                // En V6, filtramos por las carreras donde el gestor tiene PROYECTOS activos
                if (!$user->canDo('acceso_total')) {
                    if ($user->personal) {
                        // Obtenemos IDs de carrera desde los proyectos del gestor
                        $misCarrerasIds = $user->personal->proyectos->pluck('CarreraID')->unique()->toArray();
                        
                        if (!empty($misCarrerasIds)) {
                            // Filtramos personal que pertenezca a esas mismas carreras (vía proyectos)
                            $query->whereHas('proyectos', fn($q) => $q->whereIn('CarreraID', $misCarrerasIds));
                        } else {
                            // Gestor sin asignación: No ve nada
                            $query->whereRaw('1 = 0');
                        }
                    }
                }

                $baseQuery = clone $query;

                return [
                    'totalDocentes'     => $baseQuery->count(),
                    'activos'           => (clone $baseQuery)->where('Activo', 1)->count(),
                    'inactivos'         => (clone $baseQuery)->where('Activo', 0)->count(),
                    
                    // Pendientes PDF: Docentes sin archivo en su formación
                    'pendientesPDF'     => (clone $baseQuery)->whereDoesntHave('formaciones', fn($q) => 
                                                $q->whereNotNull('RutaArchivo')
                                            )->count(),
                    
                    'totalMaterias'     => Materia::count(),
                    
                    // Proyectos V6
                    'proyectosActivos'  => Proyectoinvestigacion::where('Estado', 'En Ejecución')->count(),
                    
                    // Por Contrato V6 (TipocontratoID)
                    'porContrato'       => (clone $baseQuery)
                        ->select('TipocontratoID', DB::raw('count(*) as total'))
                        ->whereNotNull('TipocontratoID')
                        ->groupBy('TipocontratoID')
                        ->with('contrato:TipocontratoID,Nombrecontrato')
                        ->get(),
                ];
            });

            return view('dashboard', $stats);
        }

        // ---------------------------------------------------------------------
        // 2. LÓGICA PARA DOCENTES (Mi Carga Académica)
        // ---------------------------------------------------------------------
        $miCarga = 0;
        if ($user->personal) {
            // V6: Usamos la tabla pivote Personalmateria
            $miCarga = $user->personal->materias()
                            ->wherePivot('Gestion', $gestionActual)
                            ->count();
        }
        
        return view('dashboard', [
            'misMaterias' => $miCarga,
            'isDocente'   => true,
            'totalDocentes' => 0, // Defaults para evitar error en vista
            'activos' => 0,
            'totalMaterias' => 0,
            'pendientesPDF' => 0
        ]);
    }
}