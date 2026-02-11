@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    {{-- 1. ENCABEZADO INSTITUCIONAL (Limpio, solo navegación y reporte) --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 px-2">
        <div class="mb-3 mb-md-0">
            <nav aria-label="breadcrumb" class="mb-1">
                <ol class="breadcrumb mb-0" style="background: transparent; padding: 0;">
                    <li class="breadcrumb-item small text-muted text-uppercase fw-bold">Gestión Académica</li>
                    <li class="breadcrumb-item small text-upds-blue text-uppercase fw-bold active">Expediente del Docente</li>
                </ol>
            </nav>
            <h1 class="fw-black text-upds-blue mb-0 tracking-tight" style="font-size: 1.75rem;">
                EXPEDIENTE DIGITAL
            </h1>
        </div>
        
        <div class="d-flex gap-2">
            <a href="{{ route('personal.index') }}" class="btn btn-white border rounded-pill px-4 fw-bold text-xs shadow-sm hover-scale">
                <i class="bi bi-arrow-left me-2"></i> VOLVER
            </a>
            
            <a href="{{ route('personal.print', $docente->PersonalID) }}" target="_blank" class="btn btn-sia-primary shadow-sm rounded-pill px-4 fw-bold text-xs hover-scale">
                <i class="bi bi-printer-fill me-2"></i> IMPRIMIR KARDEX
            </a>
        </div>
    </div>

    <div class="row g-4">
        
        {{-- 2. COLUMNA IZQUIERDA: TARJETA DE IDENTIDAD --}}
        <div class="col-lg-4 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
                <div class="card-body p-0">
                    {{-- Avatar Section --}}
                    <div class="bg-gray-50 p-5 text-center border-bottom border-light">
                        <div class="position-relative d-inline-block mb-3">
                            <img src="{{ $docente->Fotoperfil ? asset('storage/' . $docente->Fotoperfil) : 'https://ui-avatars.com/api/?name='.urlencode($docente->Nombrecompleto).'&background=f1f5f9&color=003566' }}" 
                                 class="rounded-circle border border-4 border-white shadow-md object-cover" width="140" height="140">
                            
                            <div class="position-absolute bottom-0 end-0 translate-middle-x mb-n1">
                                @if($docente->Activo)
                                    <span class="badge bg-success rounded-pill border border-2 border-white px-3 shadow-sm" style="font-size: 0.65rem;">ACTIVO</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill border border-2 border-white px-3 shadow-sm" style="font-size: 0.65rem;">INACTIVO</span>
                                @endif
                            </div>
                        </div>
                        
                        <h5 class="fw-black text-upds-blue mb-1" style="font-size: 1.1rem; line-height: 1.2;">
                            {{ $docente->nombre_institucional }}
                        </h5>
                        <p class="text-muted small fw-bold text-uppercase mt-2 mb-0" style="letter-spacing: 1px;">
                            {{ $docente->cargo->Nombrecargo ?? 'DOCENTE' }}
                        </p>
                    </div>

                    {{-- Contact Info --}}
                    <div class="p-4">
                        <label class="text-xxs fw-bold text-muted text-uppercase mb-3 d-block tracking-wider">Información de Enlace</label>
                        
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-blue-soft text-upds-blue rounded-3 p-2 me-3"><i class="bi bi-envelope-at"></i></div>
                            <div class="text-truncate">
                                <small class="d-block text-muted text-xxs fw-bold">CORREO INSTITUCIONAL</small>
                                <span class="small fw-bold text-dark">{{ $docente->Correoelectronico }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-blue-soft text-upds-blue rounded-3 p-2 me-3"><i class="bi bi-whatsapp"></i></div>
                            <div>
                                <small class="d-block text-muted text-xxs fw-bold">TELÉFONO / MÓVIL</small>
                                <span class="small fw-bold text-dark">{{ $docente->Telelefono ?? 'SIN REGISTRO' }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="bg-blue-soft text-upds-blue rounded-3 p-2 me-3"><i class="bi bi-card-text"></i></div>
                            <div>
                                <small class="d-block text-muted text-xxs fw-bold">IDENTIFICACIÓN</small>
                                <span class="small fw-bold text-dark">CI: {{ $docente->Ci }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Resumen de Seguridad --}}
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                <h6 class="text-xxs fw-bold text-muted text-uppercase mb-3">Acceso al Sistema</h6>
                @if($docente->usuario && $docente->usuario->Activo)
                    <div class="d-flex align-items-center text-success small fw-bold">
                        <i class="bi bi-shield-check fs-5 me-2"></i> Cuenta Habilitada
                    </div>
                @else
                    <div class="d-flex align-items-center text-muted small fw-bold">
                        <i class="bi bi-shield-lock fs-5 me-2"></i> Sin Acceso
                    </div>
                @endif
            </div>
        </div>

        {{-- 3. COLUMNA DERECHA: PESTAÑAS Y CONTENIDO DETALLADO --}}
        <div class="col-lg-8 col-xl-9">
            
            {{-- Resumen Laboral --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-4 border-end-md">
                            <div class="ps-md-2">
                                <label class="text-xxs fw-bold text-muted text-uppercase d-block mb-1">Tipo de Contrato</label>
                                <span class="small fw-bold text-dark text-uppercase">{{ $docente->contrato->Nombrecontrato ?? 'NO DEFINIDO' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4 border-end-md">
                            <div class="ps-md-2">
                                <label class="text-xxs fw-bold text-muted text-uppercase d-block mb-1">Trayectoria Docente</label>
                                <span class="small fw-bold text-dark">{{ $docente->Añosexperiencia ?? '0' }} AÑOS REGISTRADOS</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="ps-md-2">
                                <label class="text-xxs fw-bold text-muted text-uppercase d-block mb-1">Máximo Grado Alcanzado</label>
                                <span class="small fw-bold text-upds-blue text-uppercase">{{ $docente->grado->Nombregrado ?? 'LICENCIATURA' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SISTEMA DE PESTAÑAS --}}
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                <div class="card-header bg-white border-bottom p-0">
                    <ul class="nav nav-tabs sia-tabs border-0" id="profileTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-formacion" type="button">
                                <i class="bi bi-mortarboard me-2"></i> FORMACIÓN
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-carga" type="button">
                                <i class="bi bi-calendar3 me-2"></i> CARGA {{ date('Y') }}
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-proyectos" type="button">
                                <i class="bi bi-rocket-takeoff me-2"></i> PROYECTOS
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-produccion" type="button">
                                <i class="bi bi-journal-check me-2"></i> PUBLICACIONES
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-4 bg-gray-50">
                    <div class="tab-content">
                        
                        {{-- ========================================================= --}}
                        {{-- TAB 1: FORMACIÓN ACADÉMICA (Botón "Subir PDF" en la fila) --}}
                        {{-- ========================================================= --}}
                        <div class="tab-pane fade show active" id="tab-formacion">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h6 class="fw-bold text-upds-blue mb-0">Títulos y Postgrados</h6>
                                {{-- Botón para agregar NUEVO registro, no para subir pdf a uno existente --}}
         <button class="btn btn-outline-upds btn-sm rounded-pill px-3 shadow-sm transition-all" data-bs-toggle="modal" data-bs-target="#modalCrearFormacion">
    <i class="bi bi-plus-lg me-1"></i> NUEVO TÍTULO
</button>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-hover align-middle bg-white rounded-3 shadow-sm border-light">
                                    <thead class="bg-light">
                                        <tr class="text-xxs text-muted fw-bold text-uppercase">
                                            <th class="ps-3 py-2">Grado</th>
                                            <th>Título Obtenido</th>
                                            <th>Institución</th>
                                            <th class="text-end pe-4">Respaldo Digital</th>
                                        </tr>
                                    </thead>
                                    <tbody>
    @forelse($docente->formaciones as $f)
        <tr>
            {{-- 1. Grado (Nivel) --}}
            <td class="ps-3 align-middle">
                <span class="badge bg-blue-soft text-upds-blue border border-blue-100">
                    {{ $f->grado->Nombregrado ?? 'GRADO' }}
                </span>
            </td>

            {{-- 2. Título y Profesión (Aquí estaba el fallo visual) --}}
            <td class="align-middle">
                {{-- Nombre de la Profesión (Lo que faltaba) --}}
                <div class="fw-bold text-dark text-uppercase mb-1">
                    {{ $f->NombreProfesion }}
                </div>
                {{-- Título Obtenido (Ej: Licenciatura) --}}
                <div class="text-xs text-muted fw-bold">
                    <i class="bi bi-award me-1"></i> {{ $f->Tituloobtenido }}
                </div>
            </td>

            {{-- 3. Institución --}}
            <td class="align-middle text-muted small">
                {{ $f->centro->Nombrecentro ?? 'Institución Externa' }}
            </td>

            {{-- 4. Botones de Acción (Subir/Ver) --}}
            <td class="text-end pe-3 align-middle">
                @if($f->RutaArchivo)
                    <div class="d-flex justify-content-end gap-2">
                        {{-- Ver PDF --}}
                        <a href="{{ asset('storage/' . $f->RutaArchivo) }}" target="_blank" class="btn btn-sm btn-ghost-primary fw-bold text-xs" title="Ver Documento">
                            <i class="bi bi-file-earmark-pdf-fill me-1"></i> VER
                        </a>
                        {{-- Reemplazar (Opcional) --}}
                        <button class="btn btn-sm btn-ghost-warning" onclick="abrirModalPDF('{{ $f->FormacionID }}', '{{ $f->NombreProfesion }}')" title="Actualizar Archivo">
                            <i class="bi bi-arrow-repeat"></i>
                        </button>
                    </div>
                @else
                    {{-- Botón de Subida Contextual --}}
                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold text-xs" 
                            onclick="abrirModalPDF('{{ $f->FormacionID }}', '{{ $f->NombreProfesion }}')">
                        <i class="bi bi-cloud-upload-fill me-1"></i> SUBIR RESPALDO
                    </button>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center py-5">
                <i class="bi bi-mortarboard display-6 text-muted opacity-25"></i>
                <p class="text-muted small mt-2">No se encontraron registros de formación académica.</p>
            </td>
        </tr>
    @endforelse
</tbody>
                                </table>
                            </div>
                        </div>

                        {{-- ========================================================= --}}
                        {{-- TAB 2: CARGA HORARIA (Botón "Subir Informe" en la fila)   --}}
                        {{-- ========================================================= --}}
                        <div class="tab-pane fade" id="tab-carga">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h6 class="fw-bold text-upds-blue mb-0">Docencia Gestión {{ date('Y') }}</h6>
                                <a href="{{ route('carga.create', ['docente_id' => $docente->PersonalID]) }}" class="btn btn-sia-primary btn-sm rounded-pill px-3 shadow-sm">
                                    <i class="bi bi-calendar-plus me-1"></i> ASIGNAR MATERIA
                                </a>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-hover align-middle bg-white rounded-3 shadow-sm">
                                    <thead class="bg-light">
                                        <tr class="text-xxs text-muted fw-bold text-uppercase">
                                            <th class="ps-3">Materia</th>
                                            <th class="text-center">Grupo</th>
                                            <th class="text-center">Modalidad</th>
                                            <th class="text-end pe-4">Informe / Autoevaluación</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($docente->materias as $m)
                                            <tr>
                                                <td class="ps-3">
                                                    <div class="fw-bold text-dark">{{ $m->Nombremateria }}</div>
                                                    <div class="d-flex flex-wrap gap-1 mt-1">
                                                        @foreach($m->carreras->take(2) as $carrera)
                                                            <span class="badge bg-gray-100 text-muted border text-xxs">{{ Str::limit($carrera->Nombrecarrera, 20) }}</span>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="fw-black text-upds-blue fs-5">{{ $m->carga->Grupo }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge {{ $m->carga->Modalidad == 'Virtual' ? 'bg-purple-soft text-purple' : 'bg-green-soft text-green' }}">
                                                        {{ $m->carga->Modalidad }}
                                                    </span>
                                                </td>
                                                <td class="text-end pe-3">
                                                    {{-- LOGICA CONTEXTUAL --}}
                                                    @if($m->carga->RutaAutoevaluacion)
                                                        {{-- Si ya subió informe --}}
                                                        <a href="{{ asset('storage/'.$m->carga->RutaAutoevaluacion) }}" target="_blank" class="btn btn-sm btn-ghost-success fw-bold text-xs">
                                                            <i class="bi bi-check-circle-fill me-1"></i> INFORME OK
                                                        </a>
                                                    @else
                                                        {{-- Si falta informe --}}
                                                        <button class="btn btn-sm btn-outline-warning rounded-pill px-3 fw-bold text-xs"
                                                                onclick="abrirModalAutoeval('{{ $m->carga->PersonalmateriaID }}', '{{ $m->Nombremateria }}')">
                                                            <i class="bi bi-upload me-1"></i> SUBIR INFORME
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-5 text-muted small">
                                                    <i class="bi bi-calendar-x display-4 opacity-50"></i>
                                                    <p class="mt-2 mb-0">No tiene carga asignada.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- ========================================================= --}}
                        {{-- TAB 3: PROYECTOS (Separado de Publicaciones)              --}}
                        {{-- ========================================================= --}}
                        <div class="tab-pane fade" id="tab-proyectos">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h6 class="fw-bold text-upds-blue mb-0">Proyectos de Investigación</h6>
                                <button class="btn btn-outline-upds btn-sm rounded-pill px-3" onclick="alert('Modal Crear Proyecto')">
                                    <i class="bi bi-lightbulb me-1"></i> NUEVO PROYECTO
                                </button>
                            </div>

                            <div class="row g-3">
                                @forelse($docente->proyectos as $proyecto)
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded-3 bg-white shadow-sm h-100 position-relative">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="badge bg-primary text-white text-xxs">{{ $proyecto->CodigoProyecto ?? 'INV' }}</span>
                                                <small class="text-muted fw-bold text-xxs">
                                                    {{ $proyecto->pivot->FechaInicio ? date('d/m/Y', strtotime($proyecto->pivot->FechaInicio)) : 'N/A' }}
                                                </small>
                                            </div>
                                            <h6 class="fw-bold text-dark mb-2 line-clamp-2" style="font-size: 0.9rem;">
                                                {{ $proyecto->Nombreproyecto }}
                                            </h6>
                                            <div class="d-flex align-items-center gap-2 mt-3">
                                                <span class="badge bg-light text-dark border">{{ $proyecto->pivot->Rol }}</span>
                                                @if($proyecto->pivot->EsResponsable)
                                                    <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> Líder</span>
                                                @endif
                                            </div>
                                            {{-- Botón Contextual de Proyecto --}}
                                            <div class="mt-3 pt-3 border-top d-flex justify-content-end">
                                                <button class="btn btn-sm btn-link text-decoration-none p-0 text-xs fw-bold text-primary">
                                                    <i class="bi bi-folder2-open me-1"></i> GESTIONAR AVANCES
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 text-center py-5 text-muted small">No participa en proyectos actualmente.</div>
                                @endforelse
                            </div>
                        </div>

                        {{-- ========================================================= --}}
                        {{-- TAB 4: PUBLICACIONES (Producción Intelectual)             --}}
                        {{-- ========================================================= --}}
                        <div class="tab-pane fade" id="tab-produccion">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h6 class="fw-bold text-upds-blue mb-0">Producción Intelectual</h6>
                                <button class="btn btn-sia-primary btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalFastPub">
                                    <i class="bi bi-plus-lg me-1"></i> REGISTRAR OBRA
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-sm align-middle bg-white rounded-3 shadow-sm">
                                    <thead class="bg-gray-100">
                                        <tr class="text-xxs text-muted fw-bold text-uppercase">
                                            <th class="ps-3 py-2">Tipo</th>
                                            <th>Título de la Publicación</th>
                                            <th class="text-center">Rol</th>
                                            <th class="text-end pe-3">Año</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($docente->publicaciones as $pub)
                                            <tr>
                                                <td class="ps-3"><span class="small fw-bold text-muted">{{ $pub->tipo->Nombretipo }}</span></td>
                                                <td class="small fw-bold text-dark text-uppercase">{{ $pub->Nombrepublicacion }}</td>
                                                <td class="text-center small">
                                                    <span class="badge bg-light text-dark border px-3">
                                                        {{ $pub->pivot->rol->Nombrerol ?? 'AUTOR' }}
                                                    </span>
                                                </td>
                                                <td class="text-end pe-3 small text-muted">
                                                    {{ $pub->Fechapublicacion ? \Carbon\Carbon::parse($pub->Fechapublicacion)->year : 'N/A' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-center py-5 text-muted small">No se registra producción intelectual.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ========================================================= --}}
{{-- MODALES (Ventanas Emergentes)                             --}}
{{-- ========================================================= --}}

{{-- 1. MODAL SUBIR PDF (FORMACIÓN) --}}
<div class="modal fade" id="modalSubirPDF" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-upds-blue text-white px-4">
                <h6 class="modal-title fw-bold small text-uppercase">Respaldo Digital: Formación</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('formacion.updatePDF') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="FormacionID" id="input_formacion_id">
                <div class="modal-body p-4 bg-white text-center">
                    <p class="text-muted small mb-1">Adjuntar archivo PDF para:</p>
                    <h6 class="fw-bold text-upds-blue mb-3 text-uppercase" id="label_formacion_titulo">...</h6>
                    
                    <div class="p-3 bg-gray-50 border border-dashed rounded-3">
                        <input type="file" name="archivo" class="form-control form-control-sm" accept=".pdf" required>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3 bg-gray-50">
                    <button type="button" class="btn btn-light rounded-pill px-4 btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sia-primary rounded-pill px-4 btn-sm">Guardar PDF</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 2. MODAL SUBIR INFORME (CARGA ACADÉMICA) --}}
<div class="modal fade" id="modalSubirAutoeval" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-warning text-dark px-4">
                <h6 class="modal-title fw-bold small text-uppercase">Informe Final de Materia</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            {{-- NOTA: Asegúrate de crear esta ruta o usar una genérica --}}
            <form action="#" method="POST" enctype="multipart/form-data"> 
                @csrf
                <input type="hidden" name="PersonalmateriaID" id="input_pm_id">
                <div class="modal-body p-4 bg-white text-center">
                    <p class="text-muted small mb-1">Materia:</p>
                    <h6 class="fw-bold text-dark mb-3 text-uppercase" id="label_materia_nombre">...</h6>
                    
                    <div class="p-3 bg-warning bg-opacity-10 border border-warning border-dashed rounded-3">
                        <label class="text-xxs fw-bold text-muted text-uppercase mb-2 d-block">Seleccione el Informe (PDF)</label>
                        <input type="file" name="informe" class="form-control form-control-sm" accept=".pdf" required>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3 bg-gray-50">
                    <button type="button" class="btn btn-light rounded-pill px-4 btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning rounded-pill px-4 btn-sm fw-bold">Subir Informe</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 3. MODAL REGISTRO PUBLICACIÓN (FAST TRACK) --}}
<div class="modal fade" id="modalFastPub" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-upds-blue text-white px-4">
                <h6 class="modal-title fw-bold small text-uppercase">Nueva Publicación</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('publicaciones.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4 bg-gray-50">
                    {{-- Campos de Publicación (Simplificado) --}}
                    <div class="row g-3 mb-3">
                        <div class="col-12">
                            <label class="text-xxs fw-bold text-muted text-uppercase">Título de la Obra</label>
                            <input type="text" name="Nombrepublicacion" class="form-control fw-bold border-0 bg-white shadow-sm" required>
                        </div>
                        {{-- Aquí irían los selects de Tipo y Medio si los pasas desde el controller --}}
                        <div class="col-md-4">
                            <label class="text-xxs fw-bold text-muted text-uppercase">Fecha</label>
                            <input type="date" name="Fechapublicacion" class="form-control border-0 bg-white shadow-sm" required>
                        </div>
                    </div>
                    {{-- Vinculación Automática --}}
                    <div class="bg-blue-soft rounded-3 p-3 border border-blue-100">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-check-fill text-upds-blue fs-4 me-3"></i>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">{{ $docente->nombre_institucional }}</h6>
                                <small class="text-muted">Se asignará como autor principal.</small>
                                <input type="hidden" name="autores[]" value="{{ $docente->PersonalID }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-white p-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sia-primary rounded-pill px-4 shadow-sm">Guardar Obra</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- MODAL SIMPLIFICADO: REGISTRAR NUEVA FORMACIÓN --}}
<div class="modal fade" id="modalCrearFormacion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-upds-blue text-white px-4 py-3">
                <h6 class="modal-title fw-bold small text-uppercase">Registrar Formación Académica</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            
            <form action="{{ route('formacion.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="PersonalID" value="{{ $docente->PersonalID }}">
                
                <div class="modal-body p-4 bg-gray-50">
                    <div class="row g-3">
                        {{-- 1. Nivel Académico --}}
                        <div class="col-12">
                            <label class="text-xxs fw-bold text-muted text-uppercase d-block mb-1">Nivel (Grado)</label>
                            <select name="GradoacademicoID" class="form-select form-select-sm border-0 shadow-sm" required>
                                <option value="" disabled selected>Seleccione el nivel...</option>
                                @foreach($grados as $g)
                                    <option value="{{ $g->GradoacademicoID }}">{{ $g->Nombregrado }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- 2. Título (Único campo de texto ahora) --}}
                        <div class="col-12">
                            <label class="text-xxs fw-bold text-muted text-uppercase d-block mb-1">Título / Carrera (Como dice el cartón)</label>
                            <input type="text" name="Tituloobtenido" class="form-control form-control-sm border-0 shadow-sm fw-bold" 
                                   placeholder="Ej: Licenciado en Ingeniería de Sistemas" required>
                        </div>

                        {{-- 3. Universidad --}}
                        <div class="col-12">
                            <label class="text-xxs fw-bold text-muted text-uppercase d-block mb-1">Universidad / Institución</label>
                            <select name="CentroformacionID" class="form-select form-select-sm border-0 shadow-sm" required>
                                <option value="" disabled selected>Seleccione la institución...</option>
                                @foreach($centros as $c)
                                    <option value="{{ $c->CentroformacionID }}">{{ $c->Nombrecentro }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- 4. Año y PDF --}}
                        <div class="col-4">
                            <label class="text-xxs fw-bold text-muted text-uppercase d-block mb-1">Año</label>
                            <input type="number" name="Añosestudios" class="form-control form-control-sm border-0 shadow-sm text-center" 
                                   value="{{ date('Y') }}" required>
                        </div>
                        <div class="col-8">
                            <label class="text-xxs fw-bold text-muted text-uppercase d-block mb-1">Respaldo PDF</label>
                            <input type="file" name="archivo" class="form-control form-control-sm border-0 shadow-sm" accept=".pdf">
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 p-3 bg-white">
                    <button type="button" class="btn btn-light rounded-pill px-4 btn-sm fw-bold" data-bs-dismiss="modal">CANCELAR</button>
                    <button type="submit" class="btn btn-sia-primary rounded-pill px-4 btn-sm fw-bold">GUARDAR</button>
                </div>
            </form>
        </div>
    </div>
</div> 

{{-- SCRIPTS JS PARA LOS MODALES --}}
<script>
    // Modal Formación
    function abrirModalPDF(id, titulo) {
        document.getElementById('input_formacion_id').value = id;
        document.getElementById('label_formacion_titulo').innerText = titulo;
        new bootstrap.Modal(document.getElementById('modalSubirPDF')).show();
    }

    // Modal Carga Académica
    function abrirModalAutoeval(id, materia) {
        document.getElementById('input_pm_id').value = id;
        document.getElementById('label_materia_nombre').innerText = materia;
        new bootstrap.Modal(document.getElementById('modalSubirAutoeval')).show();
    }
</script>

<style>
    /* Estilos Específicos */
    :root { --upds-blue: #003566; --upds-gold: #ffc300; --gray-50: #f8fafc; --blue-soft: #eef2f7; }
    .fw-black { font-weight: 900; }
    .text-xxs { font-size: 0.62rem; letter-spacing: 0.5px; }
    .bg-gray-50 { background-color: var(--gray-50) !important; }
    .bg-blue-soft { background-color: var(--blue-soft); }
    .bg-purple-soft { background-color: #f3e8ff; }
    .text-purple { color: #7e22ce; }
    .bg-green-soft { background-color: #dcfce7; }
    .text-green { color: #15803d; }
    .object-cover { object-fit: cover; }
    
    /* Pestañas */
    .sia-tabs .nav-link { color: #94a3b8; font-weight: 800; font-size: 0.72rem; padding: 1.2rem 1.5rem; border: none; border-bottom: 3px solid transparent; transition: 0.3s; }
    .sia-tabs .nav-link.active { color: var(--upds-blue); border-bottom-color: var(--upds-gold); background: white; }
    .sia-tabs .nav-link:hover:not(.active) { color: var(--upds-blue); border-bottom-color: #e2e8f0; }
    
    /* Botones */
    .btn-sia-primary { background-color: var(--upds-blue); color: white; border: none; transition: 0.3s; }
    .btn-sia-primary:hover { background-color: #00284d; transform: translateY(-1px); color: white; }
    .btn-white { background-color: white; border-color: #e2e8f0; color: #64748b; }
    .btn-white:hover { background-color: #f8fafc; border-color: #cbd5e1; color: #0f172a; transform: translateY(-1px); }
    .btn-ghost-primary { color: var(--upds-blue); background: transparent; border: none; }
    .btn-ghost-primary:hover { background: #eff6ff; }
    .btn-ghost-success { color: #16a34a; background: #f0fdf4; border: 1px solid #dcfce7; }
    .btn-outline-danger { border-color: #fee2e2; color: #dc2626; }
    .btn-outline-danger:hover { background: #dc2626; color: white; border-color: #dc2626; }
    .btn-outline-warning { border-color: #fef3c7; color: #d97706; }
    .btn-outline-warning:hover { background: #d97706; color: white; border-color: #d97706; }
    .hover-scale:hover { transform: scale(1.02); transition: 0.2s; }
    
    .border-end-md { border-right: 1px solid #e2e8f0; }
    @media (max-width: 768px) { .border-end-md { border-right: none; border-bottom: 1px solid #e2e8f0; padding-bottom: 1rem; } }
    @media print { .btn, nav, .card-header button, .modal, .breadcrumb { display: none !important; } body { background: white !important; } }
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>
@endsection