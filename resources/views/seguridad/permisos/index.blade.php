@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 font-black text-slate-800">Diccionario de Permisos</h2>
            <p class="text-slate-500 small text-uppercase tracking-wider fw-bold">
                <i class="bi bi-key-fill me-1"></i> Definición de Capacidades Técnicas (SEG-03)
            </p>
        </div>
        <button type="button" class="btn btn-primary fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalPermiso">
            <i class="bi bi-plus-lg me-2"></i> Crear Permiso
        </button>
    </div>

    {{-- FEEDBACK DE ERRORES DEL MODAL --}}
    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <ul class="mb-0 small fw-bold">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-slate-50 border-bottom">
                        <tr>
                            <th class="ps-4 py-3 text-slate-600 font-bold small text-uppercase">Nombre Técnico (Slug)</th>
                            <th class="py-3 text-slate-600 font-bold small text-uppercase">Descripción de Función</th>
                            <th class="text-center py-3 text-slate-600 font-bold small text-uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permisos as $p)
                        <tr>
                            <td class="ps-4">
                                <code class="bg-slate-100 text-primary px-2 py-1 rounded fw-bold border border-slate-200">
                                    {{ $p->Nombrepermiso }}
                                </code>
                            </td>
                            <td class="text-slate-600 small">{{ $p->Descripcion ?? 'Sin descripción definida.' }}</td>
                            <td class="text-center">
                                {{-- 
                                   PROTECCIÓN: No permitimos borrar permisos críticos del sistema 
                                   (Hardcoded safety en la vista también)
                                --}}
                                @if(!in_array($p->Nombrepermiso, ['acceso_total', 'ver_perfil_propio']))
                                    <form action="{{ route('permisos.destroy', $p->PermisosID) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Estás seguro de eliminar este permiso? Esto afectará a los cargos que lo tengan asignado.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-link text-danger p-0" title="Eliminar del diccionario">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted" title="Permiso del Sistema (Protegido)"><i class="bi bi-shield-lock-fill"></i></span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL DE REGISTRO --}}
<div class="modal fade" id="modalPermiso" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form action="{{ route('permisos.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-black">Nuevo Permiso Global</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info border-0 bg-blue-50 text-blue-800 small mb-3">
                        <i class="bi bi-info-circle-fill me-1"></i> 
                        El sistema formateará automáticamente el nombre (ej: "Ver Reportes" -> "ver_reportes").
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nombre Técnico <span class="text-danger">*</span></label>
                        <input type="text" name="Nombrepermiso" class="form-control" placeholder="ej: aprobar_presupuesto" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold">Descripción <span class="text-danger">*</span></label>
                        <textarea name="Descripcion" class="form-control" rows="3" placeholder="Describe brevemente qué permite hacer este permiso..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">
                        <i class="bi bi-save me-2"></i> Registrar Permiso
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection