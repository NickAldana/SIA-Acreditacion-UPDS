<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, Auth, DB, Cache, Storage, Gate};
// Importamos los Modelos V3.1 Correctos
use App\Models\{Personal, Carrera, Tipocontrato, Gradoacademico, Centroformacion, Formacion, Cargo, Usuario};

class PersonalController extends Controller
{
    // =========================================================================
    // 0. LISTADO Y BÚSQUEDA (OPTIMIZADO PARA V3.1)
    // =========================================================================
// =========================================================================
    // 1. LISTADO AVANZADO (FILTROS + BÚSQUEDA + CACHÉ)
    // =========================================================================
    public function index(Request $request)
    {
        /** @var \App\Models\Usuario $currentUser */
        $currentUser = Auth::user();
        $gestionActual = date('Y'); // Año dinámico

        // ---------------------------------------------------------------------
        // A. PREPARACIÓN DE CATÁLOGOS (Para los Selects del Filtro)
        // ---------------------------------------------------------------------
        // Usamos Cache para optimizar la carga
        
        $carreras = Cache::remember('filtro_carreras', 3600, function() {
            return Carrera::orderBy('Nombrecarrera')->get(['CarreraID', 'Nombrecarrera']);
        });

        $cargos = Cache::remember('filtro_cargos', 3600, function() {
            return Cargo::orderBy('Nombrecargo')->get(['CargoID', 'Nombrecargo']);
        });

        // ---------------------------------------------------------------------
        // B. CONSULTA BASE (OPTIMIZADA)
        // ---------------------------------------------------------------------
        $query = Personal::select([
                'PersonalID', 'Nombrecompleto', 'Apellidopaterno', 'Apellidomaterno', 
                'Ci', 'Correoelectronico', 'Telelefono', 'Fotoperfil', 
                'CargoID', 'TipocontratoID', 'Activo'
            ])
            ->with([
                'cargo:CargoID,Nombrecargo', 
                'contrato:TipocontratoID,Nombrecontrato'
            ])
            // KPI: Contamos materias asignadas en la gestión actual
            // AJUSTE: Especificamos 'Personalmateria.Gestion' para evitar ambigüedad
            ->withCount(['materias' => function($q) use ($gestionActual) {
                $q->where('Personalmateria.Gestion', $gestionActual); 
            }]);

        // ---------------------------------------------------------------------
        // C. APLICACIÓN DE FILTROS INTELIGENTES
        // ---------------------------------------------------------------------

        // 1. Buscador General (Nombre, CI, Correo)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('Nombrecompleto', 'like', "%{$search}%")
                  ->orWhere('Apellidopaterno', 'like', "%{$search}%")
                  ->orWhere('Apellidomaterno', 'like', "%{$search}%")
                  ->orWhere('Ci', 'like', "%{$search}%")
                  ->orWhere('Correoelectronico', 'like', "%{$search}%");
            });
        }

        // 2. Filtro por Estado
        if ($request->filled('estado')) {
            $query->where('Activo', $request->estado);
        }

        // 3. Filtro por Cargo
        if ($request->filled('cargo_id')) {
            $query->where('CargoID', $request->cargo_id);
        }

        // 4. Filtro por Carrera (CORREGIDO PARA TU NUEVA BD)
        // Lógica: Personal -> Materias -> Carreras (Relación N:M)
        if ($request->filled('carrera_id')) {
            $query->whereHas('materias', function($qMateria) use ($request, $gestionActual) {
                
                // 1. Filtramos que la materia pertenezca a la carrera seleccionada
                $qMateria->whereHas('carreras', function($qCarrera) use ($request) {
                    $qCarrera->where('Carrera.CarreraID', $request->carrera_id);
                });

                // 2. (Opcional) Validamos que la asignación sea de este año
                // Si quitas esto, te mostrará docentes que dieron clases en esa carrera hace 10 años.
                // Es mejor dejarlo para ver solo el personal "activo" en esa carrera.
                $qMateria->where('Personalmateria.Gestion', $gestionActual);
            });
        }

        // ---------------------------------------------------------------------
        // D. SEGURIDAD: VISIÓN DE TÚNEL (RBAC)
        // ---------------------------------------------------------------------
        if (!$currentUser->canDo('acceso_total')) {
            // Lógica: Solo ver personal de jerarquía igual o inferior
            $miNivel = $currentUser->personal->cargo->nivel_jerarquico ?? 1000;
            
            $query->whereHas('cargo', function($q) use ($miNivel) {
                $q->where('nivel_jerarquico', '>=', $miNivel); 
            });
        }

        // ---------------------------------------------------------------------
        // E. ORDENAMIENTO Y PAGINACIÓN
        // ---------------------------------------------------------------------
        $personales = $query->orderBy('Apellidopaterno')
                            ->orderBy('Apellidomaterno') // Agregado para mejor orden visual
                            ->orderBy('Nombrecompleto')
                            ->paginate(10)
                            ->withQueryString();

        return view('personal.index', compact('personales', 'carreras', 'cargos'));
    }

    // =========================================================================
    // 1. CREACIÓN (VISTA Y LÓGICA DE NEGOCIO)
    // =========================================================================
    public function create()
    {
        /** @var \App\Models\Usuario $currentUser */
        $currentUser = Auth::user();
        
        // Catálogos en Caché (24h)
        $carreras = Cache::remember('cat_carreras_all', 86400, fn() => Carrera::orderBy('Nombrecarrera')->get(['CarreraID', 'Nombrecarrera']));
        $grados = Cache::remember('cat_grados_academicos', 86400, fn() => Gradoacademico::all(['GradoacademicoID', 'Nombregrado']));
        $tiposContrato = Cache::remember('cat_tipos_contrato', 86400, fn() => Tipocontrato::all(['TipocontratoID', 'Nombrecontrato']));

        // Cargos sugeridos (Filtrado por jerarquía)
        // Si no tiene cargo asignado, asumimos nivel bajo (1000)
        $miNivel = $currentUser->personal->cargo->nivel_jerarquico ?? 1000;
        
        // Solo mostramos cargos de menor jerarquía (Número mayor = Menor rango)
        $cargos = Cargo::where('nivel_jerarquico', '>', $miNivel)
                       ->orderBy('nivel_jerarquico', 'asc')
                       ->get(['CargoID', 'Nombrecargo']);
        
        // Si es Super Admin, ve todos
        if ($currentUser->canDo('acceso_total')) {
            $cargos = Cargo::orderBy('Nombrecargo')->get(['CargoID', 'Nombrecargo']);
        }

        return view('personal.create', compact('tiposContrato', 'cargos', 'carreras', 'grados'));
    }

public function store(Request $request)
    {
        // 0. Validaciones (Se mantienen las que ya tienes arriba en el controlador)
        $request->validate([
            'Nombrecompleto' => 'required|string|max:100',
            'Apellidopaterno' => 'required|string|max:100',
            'Ci' => 'required|string|unique:Personal,Ci',
            'CargoID' => 'required|exists:Cargo,CargoID',
            'TipocontratoID' => 'required|exists:Tipocontrato,TipocontratoID',
            'GradoacademicoID' => 'required|exists:Gradoacademico,GradoacademicoID',
            'ArchivoTitulo' => 'nullable|file|mimes:pdf|max:5120', // VAL-03: PDF max 5MB
        ]);

        DB::beginTransaction();
        try {
            // 1. PREPARAR DATOS
            $nombreLimpio  = Str::title(trim($request->Nombrecompleto)); 
            $paternoLimpio = Str::title(trim($request->Apellidopaterno));
            $maternoLimpio = $request->Apellidomaterno ? Str::title(trim($request->Apellidomaterno)) : null;

            // Generar Correo
            $primerNombreSlug = Str::slug(explode(' ', $nombreLimpio)[0]); 
            $paternoSlug      = Str::slug($paternoLimpio);
            $inicialMaterno   = $maternoLimpio ? substr(Str::slug($maternoLimpio), 0, 1) : '';
            $emailGenerado    = "sc.{$primerNombreSlug}.{$paternoSlug}" . ($inicialMaterno ? ".{$inicialMaterno}" : "") . "@upds.net.bo";

            $contador = 1;
            while (Usuario::where('Correo', $emailGenerado)->exists()) {
                $emailGenerado = "sc.{$primerNombreSlug}.{$paternoSlug}" . ($inicialMaterno ? ".{$inicialMaterno}" : "") . str_pad($contador, 2, '0', STR_PAD_LEFT) . "@upds.net.bo";
                $contador++;
            }

            // 2. CREAR USUARIO PRIMERO
            // Idpersonal es NULLABLE en BD, así que esto es seguro.
            $nuevoUsuario = Usuario::create([
        'NombreUsuario' => explode('@', $emailGenerado)[0],
        'Correo'        => $emailGenerado,
        'Password'      => Hash::make($request->Ci), // <--- CAMBIO AQUÍ: De 'Contraseña' a 'Password'
        'Activo'        => 1,
        'Idpersonal'    => null 
    ]);
            

            // 3. CREAR PERSONAL
            $nuevoDocente = Personal::create([
                'Nombrecompleto'    => $nombreLimpio,
                'Apellidopaterno'   => $paternoLimpio,
                'Apellidomaterno'   => $maternoLimpio,
                'Ci'                => $request->Ci,
                'Genero'            => $request->Genero,
                'Telelefono'        => $request->Telefono,
                'Correoelectronico' => $emailGenerado,
                'CargoID'           => $request->CargoID,
                'TipocontratoID'    => $request->TipocontratoID,
                'GradoacademicoID'  => $request->GradoacademicoID,
                'Añosexperiencia'   => $request->AniosExperiencia,
                'Activo'            => 1,
                'UsuarioID'         => $nuevoUsuario->UsuarioID 
            ]);

            // 4. ACTUALIZAR USUARIO (Cerrar el círculo)
            $nuevoUsuario->Idpersonal = $nuevoDocente->PersonalID;
            $nuevoUsuario->save();

            // 5. REGISTRAR FORMACIÓN
            $rutaPDF = null;
            if ($request->hasFile('ArchivoTitulo')) {
                $rutaPDF = $request->file('ArchivoTitulo')->store('titulos', 'public');
            }

            Formacion::create([
                'PersonalID'        => $nuevoDocente->PersonalID,
                'CentroformacionID' => 1, // Ajustar si tienes el ID real en el request
                'GradoacademicoID'  => $request->GradoacademicoID,
                'Tituloobtenido'    => Str::upper($request->TituloObtenido),
                'Añosestudios'      => $request->AñoEstudios,
                'RutaArchivo'       => $rutaPDF
            ]);

            // =========================================================
            // SEG-05: REGISTRO EN BITÁCORA (CRÍTICO)
            // =========================================================
            \App\Models\Bitacora::registrar(
                'CREAR_PERSONAL', 
                "Se registró nuevo personal: {$nombreLimpio} {$paternoLimpio} (CI: {$request->Ci}) con usuario: {$emailGenerado}."
            );

            DB::commit();

            Cache::forget('dashboard_stats_global');
            Cache::forget('dashboard_stats_user_' . Auth::id());

            return redirect()->route('personal.index')
                ->with('success', "Personal registrado correctamente: $nombreLimpio.");

        } catch (\Exception $e) {
            DB::rollBack();
            // Si falló, borramos el archivo subido para no dejar basura
            if (isset($rutaPDF)) Storage::disk('public')->delete($rutaPDF);
            
            return back()->with('error', 'Error en base de datos: ' . $e->getMessage())->withInput();
        }
    }

    // =========================================================================
    // 2. EDICIÓN ADMINISTRATIVA
    // =========================================================================
    public function edit($id)
    {
        $personal = Personal::findOrFail($id);
        
        // Usamos los mismos catálogos cacheados del create()
        // Esto ahorra 3 consultas a la base de datos cada vez que entras a editar
        $cargos = Cache::remember('cat_cargos_all', 86400, fn() => Cargo::orderBy('Nombrecargo')->get());
        $tiposContrato = Cache::remember('cat_tipos_contrato', 86400, fn() => Tipocontrato::all());
        $grados = Cache::remember('cat_grados', 86400, fn() => Gradoacademico::all());

        return view('personal.edit', compact('personal', 'cargos', 'tiposContrato', 'grados'));
    }

    public function update(Request $request, $id)
    {
        $docente = Personal::findOrFail($id);

        // Validación V3.1
        $request->validate([
            'Nombrecompleto' => 'required|string|max:100',
            'Apellidopaterno' => 'required|string|max:100',
            'Ci' => 'required|string|unique:Personal,Ci,'.$id.',PersonalID', // Ignorar propio ID
            'CargoID' => 'required|exists:Cargo,CargoID',
            'TipocontratoID' => 'required|exists:Tipocontrato,TipocontratoID',
            'Fotoperfil' => 'nullable|image|max:2048' // 2MB Max
        ]);

        // Actualización de Datos
        $docente->fill($request->except(['Fotoperfil'])); // Llenar todo menos la foto

        // Gestión de Foto (Igual que en ProfileController)
        if ($request->hasFile('Fotoperfil')) {
            if ($docente->Fotoperfil && Storage::disk('public')->exists($docente->Fotoperfil)) {
                Storage::disk('public')->delete($docente->Fotoperfil);
            }
            $docente->Fotoperfil = $request->file('Fotoperfil')->store('fotos/perfiles', 'public');
        }

        $docente->save();

        // IMPORTANTE: Si el usuario tiene login, actualizar su email también
        if ($docente->usuario) {
            $docente->usuario->Correo = $request->Correoelectronico;
            $docente->usuario->save();
        }

        return redirect()->route('personal.index')->with('success', 'Ficha de personal actualizada correctamente.');
    }
    // =========================================================================
    // 3. DETALLE (PERFIL / KARDEX)
    // =========================================================================
// =========================================================================
    // 3. DETALLE (EXPEDIENTE / KARDEX DIGITAL)
    // =========================================================================
   // =========================================================================
    // 3. DETALLE (EXPEDIENTE / KARDEX DIGITAL)
    // =========================================================================
   // =========================================================================
    // 3. DETALLE (EXPEDIENTE / KARDEX DIGITAL)
    // =========================================================================
public function show($id)
    {
        /** @var \App\Models\Usuario $currentUser */
        $currentUser = Auth::user();

        // ---------------------------------------------------------------------
        // 1. SEGURIDAD (RBAC)
        // ---------------------------------------------------------------------
        if (!$currentUser->canDo('acceso_total') && $currentUser->Idpersonal != $id) {
            abort(403, 'No tienes autorización para visualizar este expediente.');
        }

        // ---------------------------------------------------------------------
        // 2. CONSULTA INTEGRAL (OPTIMIZADA V3.1)
        // ---------------------------------------------------------------------
        $docente = Personal::with([
            // Datos Maestros del Docente
            'cargo:CargoID,Nombrecargo', 
            'contrato:TipocontratoID,Nombrecontrato',
            'grado:GradoacademicoID,Nombregrado',
            'usuario:UsuarioID,NombreUsuario,Activo,Correo',
            
            // A. CARGA ACADÉMICA (Gestión 2026 - Ajustado a tu BD)
            'materias' => function($q) {
                $q->wherePivot('Gestion', 2026) 
                  ->withPivot('PersonalmateriaID', 'Grupo', 'Modalidad', 'RutaAutoevaluacion', 'NotaEvaluacion') 
                  ->with('carreras:CarreraID,Nombrecarrera'); 
            },
            
            // B. FORMACIÓN (Historial de Títulos)
            'formaciones.centro',
            'formaciones.grado',
            
            // C. PROYECTOS (Investigación)
            'proyectos' => function($q) {
                $q->withPivot('Rol', 'EsResponsable', 'FechaInicio');
            },

            // D. PUBLICACIONES (Producción Científica)
            'publicaciones.tipo'

        ])->findOrFail($id);

        // ---------------------------------------------------------------------
        // 3. LÓGICA DE NEGOCIO Y ORDENAMIENTO
        // ---------------------------------------------------------------------
        
        // Ordenar títulos: El grado académico más alto (Doctorado/Maestría) arriba
        $docente->setRelation('formaciones', $docente->formaciones->sortByDesc('GradoacademicoID'));

        // Cargar Catálogos para los Modales (Nuevo Título / Nueva Publicación)
        // Usamos Cache para no saturar SQL Server en cada recarga de perfil
        $grados = Cache::remember('cat_grados_all', 86400, function() {
            return Gradoacademico::orderBy('GradoacademicoID', 'desc')->get(['GradoacademicoID', 'Nombregrado']);
        });

        $centros = Cache::remember('cat_centros_all', 86400, function() {
            return Centroformacion::orderBy('Nombrecentro', 'asc')->get(['CentroformacionID', 'Nombrecentro']);
        });

        // ---------------------------------------------------------------------
        // 4. RETORNO A LA VISTA
        // ---------------------------------------------------------------------
        return view('personal.show', compact('docente', 'grados', 'centros'));
    }
    // =========================================================================
    // 4. ACCIONES ADMINISTRATIVAS (PROTEGIDAS POR JERARQUÍA)
    // =========================================================================

    /**
     * Activar / Desactivar Personal (Soft Delete Lógico)
     */
   /**
     * Activar / Desactivar Personal y bloquear/desbloquear su Usuario.
     */
    public function toggleStatus($id)
    {
        // 1. Verificación de jerarquía (seguridad técnica)
        if (!$this->validarJerarquia($id)) {
            return back()->with('error', 'No tiene permisos para modificar a un usuario de rango superior.');
        }

        $docente = Personal::findOrFail($id);
        
        // 2. Cambiamos el estado del docente
        $nuevoEstado = !$docente->Activo;
        $docente->Activo = $nuevoEstado;
        $docente->save();

        // 3. BLOQUEO DE CUENTA: Sincronizamos con la tabla Usuario
        // Al poner Activo = 0 en Usuario, el middleware de Laravel le impedirá el acceso
        if ($docente->usuario) {
            $docente->usuario->Activo = $nuevoEstado;
            $docente->usuario->save();
        }

        // Limpieza de caché para reportes y dashboard
        Cache::forget('dashboard_stats_global');

        $mensaje = $nuevoEstado ? 'reincorporado y su cuenta ha sido activada' : 'dado de baja y su cuenta ha sido bloqueada';
        return back()->with('success', "El profesional ha sido $mensaje.");
    }

    /**
     * Crear Usuario Manualmente (Si el automático falló o no se creó)
     */
    public function createUser($id)
    {
        if (!$this->validarJerarquia($id)) {
            return back()->with('error', 'Acción denegada: Rango insuficiente.');
        }

        $docente = Personal::findOrFail($id);

        if (Usuario::where('Idpersonal', $id)->exists()) {
            return back()->with('error', 'Este personal ya tiene un usuario asignado.');
        }

        // Generamos credenciales por defecto
        // Usuario: Inicial nombre + Apellido (jperez)
        $slugBase = Str::slug(substr($docente->Nombrecompleto, 0, 1) . $docente->Apellidopaterno);
        $password = $docente->Ci; // Contraseña = Carnet

        // Si ya existe el username, le agregamos números
        if (Usuario::where('NombreUsuario', $slugBase)->exists()) {
            $slugBase .= rand(10, 99);
        }

        Usuario::create([
        'Idpersonal'    => $docente->PersonalID,
        'NombreUsuario' => $slugBase,
        'Correo'        => $docente->Correoelectronico,
        'Password'      => Hash::make($password), // <--- CAMBIO AQUÍ: De 'Contraseña' a 'Password'
        'Activo'        => true
    ]);

    return back()->with('success', "Usuario creado: $slugBase (Clave: $password)");
    }

    /**
     * Revocar Acceso (Eliminar Login)
     */
    public function revokeUser($id)
    {
        if (!$this->validarJerarquia($id)) {
            return back()->with('error', 'Acción denegada.');
        }

        $usuario = Usuario::where('Idpersonal', $id)->first();
        
        if ($usuario) {
            // Protección: No puedes borrar tu propio usuario
            if ($usuario->UsuarioID == Auth::id()) {
                return back()->with('error', 'No puedes eliminar tu propia cuenta de acceso.');
            }

            $usuario->delete();
            return back()->with('success', 'Acceso al sistema revocado.');
        }
        
        return back()->with('error', 'El usuario no existe.');
    }

    // =========================================================================
    // 5. REPORTES
    // =========================================================================
    
    public function printInformacion($id)
    {
        /** @var \App\Models\Usuario $currentUser */
        $currentUser = Auth::user();

        // Solo Admin o el propio dueño pueden imprimir
        if (!$currentUser->canDo('acceso_total') && $currentUser->Idpersonal != $id) {
            abort(403);
        }

        $docente = Personal::with([
            'contrato', 'cargo', 'formaciones.grado', 'materias'
        ])->findOrFail($id);
        
        return view('personal.print', compact('docente'));
    }

    // =========================================================================
    // 6. FUNCIONES PRIVADAS (SEGURIDAD)
    // =========================================================================

    /**
     * Validador de Seguridad Jerárquica (RBAC)
     * Regla: No puedes modificar a alguien con rango igual o superior al tuyo.
     * (Asumiendo: Nivel 1 = Rector, Nivel 10 = Auxiliar)
     */
    private function validarJerarquia($targetIdPersonal)
    {
        /** @var \App\Models\Usuario $currentUser */
        $currentUser = Auth::user();

        // 1. El Super Admin siempre pasa
        if ($currentUser->canDo('acceso_total')) {
            return true;
        }

        // 2. Si yo no tengo perfil de personal, no puedo gestionar a otros
        if (!$currentUser->personal || !$currentUser->personal->cargo) {
            return false; 
        }

        // 3. Obtenemos al objetivo
        $targetPersonal = Personal::with('cargo')->find($targetIdPersonal);
        
        // Si el objetivo no tiene cargo definido, permitimos editarlo para corregir
        if (!$targetPersonal || !$targetPersonal->cargo) {
            return true;
        }

        // 4. COMPARACIÓN DE NIVELES
        // En nuestro modelo Cargo:
        // 1 = Autoridad (Alto)
        // 4 = Administrativo (Bajo)
        
        $miNivel = $currentUser->personal->cargo->nivel_jerarquico; 
        $targetNivel = $targetPersonal->cargo->nivel_jerarquico;

        // Si mi nivel numérico es MAYOR o IGUAL al del objetivo, tengo MENOS o IGUAL poder.
        if ($miNivel >= $targetNivel) {
            return false;
        }

        return true;
    }
   
    // =========================================================================
    // 7. REPORTE GENERAL (LISTADO FILTRADO - DOMPDF)
    // =========================================================================
    public function report(Request $request)
    {
        /** @var \App\Models\Usuario $currentUser */
        $currentUser = Auth::user();

        // 1. Consulta Base (Idéntica al Index)
        $query = Personal::select([
                'PersonalID', 'Nombrecompleto', 'Apellidopaterno', 'Apellidomaterno', 
                'Ci', 'Correoelectronico', 'Telelefono', 
                'CargoID', 'TipocontratoID', 'Activo'
            ])
            ->with([
                'cargo:CargoID,Nombrecargo', 
                'contrato:TipocontratoID,Nombrecontrato'
            ]);

        // 2. Aplicamos Filtros (Idénticos al Index)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('Nombrecompleto', 'like', "%{$search}%")
                  ->orWhere('Apellidopaterno', 'like', "%{$search}%")
                  ->orWhere('Apellidomaterno', 'like', "%{$search}%")
                  ->orWhere('Ci', 'like', "%{$search}%");
            });
        }

        if ($request->filled('estado')) {
            $query->where('Activo', $request->estado);
        }

        if ($request->filled('cargo_id')) {
            $query->where('CargoID', $request->cargo_id);
        }

        if ($request->filled('carrera_id')) {
            $query->whereHas('materias', function($q) use ($request) {
                $q->where('CarreraID', $request->carrera_id)
                  ->where('Gestion', 2026);
            });
        }

        // 3. Seguridad (Visión de túnel)
        if (!$currentUser->canDo('acceso_total')) {
            $miNivel = $currentUser->personal->cargo->nivel_jerarquico ?? 1000;
            $query->whereHas('cargo', function($q) use ($miNivel) {
                $q->where('nivel_jerarquico', '>=', $miNivel);
            });
        }

        // 4. Obtener Datos
        $personales = $query->orderBy('Apellidopaterno')->orderBy('Nombrecompleto')->get();

        // 5. Metadatos del Reporte
        $infoFiltros = [];
        if ($request->filled('carrera_id')) {
            $c = Carrera::find($request->carrera_id);
            if($c) $infoFiltros[] = "CARRERA: " . Str::upper($c->Nombrecarrera);
        }
        if ($request->filled('cargo_id')) {
            $c = Cargo::find($request->cargo_id);
            if($c) $infoFiltros[] = "CARGO: " . Str::upper($c->Nombrecargo);
        }
        $subtitulo = empty($infoFiltros) ? "LISTADO GENERAL" : implode(" | ", $infoFiltros);

        // 6. GENERACIÓN PDF (AQUÍ ESTÁ EL CAMBIO)
        // Cargamos la vista en el motor de DomPDF
        $pdf = Pdf::loadView('personal.report_list', compact('personales', 'subtitulo'));
        
        // Configuramos tamaño carta vertical
        $pdf->setPaper('letter', 'portrait'); 

        // OPCIÓN A: stream() abre el PDF en el navegador (Recomendado para previsualizar antes de imprimir)
        return $pdf->stream('Nomina_Personal_UPDS.pdf');

        // OPCIÓN B: Si quieres que se descargue directo sin abrirse, usa download():
        // return $pdf->download('Nomina_Personal_UPDS.pdf');
    }
}