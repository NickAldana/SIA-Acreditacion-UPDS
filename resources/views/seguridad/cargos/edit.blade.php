@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Navegación y Título --}}
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('cargos.index') }}" class="text-decoration-none">Cargos</a></li>
                <li class="breadcrumb-item active">Configurar Permisos</li>
            </ol>
        </nav>
        <h2 class="h3 font-black text-slate-800">Matriz de Permisos: {{ $cargo->Nombrecargo }}</h2>
        <p class="text-slate-500 small text-uppercase tracking-wider fw-bold">
            <i class="bi bi-diagram-3 me-1"></i> Nivel Jerárquico: {{ $cargo->nivel_legible }} ({{ $cargo->nivel_jerarquico }})
        </p>
    </div>

    <form action="{{ route('cargos.update', $cargo->CargoID) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-4">
            {{-- Columna de Ajustes Básicos --}}
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3 small text-uppercase text-slate-400">Datos del Cargo</h5>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Nombre del Cargo</label>
                            <input type="text" name="Nombrecargo" class="form-control" value="{{ $cargo->Nombrecargo }}" required>
                        </div>

                        {{-- CAMBIO CRÍTICO: Input Numérico de Jerarquía --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Nivel Jerárquico (0-100) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                {{-- 
                                    VALIDACIÓN FRONTEND:
                                    oninput evita que escriban valores fuera del rango.
                                --}}
                                <input type="number" 
                                       name="nivel_jerarquico" 
                                       class="form-control @error('nivel_jerarquico') is-invalid @enderror" 
                                       value="{{ old('nivel_jerarquico', $cargo->nivel_jerarquico) }}" 
                                       min="0" 
                                       max="100" 
                                       oninput="if(this.value > 100) this.value = 100; if(this.value < 0) this.value = 0;"
                                       required>
                                <span class="input-group-text bg-light text-muted">
                                    <i class="bi bi-bar-chart-steps"></i>
                                </span>
                            </div>
                            
                            {{-- Guía Visual de Niveles --}}
                            <div class="mt-2 p-2 bg-slate-50 rounded border d-flex justify-content-between text-muted" style="font-size: 0.7rem;">
                                <div class="text-center"><strong>100</strong><br>Rector</div>
                                <div class="text-center"><strong>80</strong><br>Decano</div>
                                <div class="text-center"><strong>50</strong><br>Jefe</div>
                                <div class="text-center"><strong>10</strong><br>Docente</div>
                            </div>

                            <div class="form-text mt-1" style="font-size: 0.75rem;">
                                Un nivel superior puede editar a uno inferior.
                            </div>
                            @error('nivel_jerarquico') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary py-3 fw-bold shadow-sm">
                        <i class="bi bi-cloud-check me-2"></i> Guardar Configuración
                    </button>
                    <a href="{{ route('cargos.index') }}" class="btn btn-light py-2 text-slate-600">Cancelar</a>
                </div>
            </div>

            {{-- Columna de Selección de Permisos (SEG-03) --}}
            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Permisos Disponibles</h5>
                            <span class="badge bg-upds-blue">{{ $todosLosPermisos->count() }} Permisos Globales</span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            @foreach($todosLosPermisos as $permiso)
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 bg-slate-50 hover-shadow transition-all">
                                    <input class="form-check-input ms-0 me-3" type="checkbox" 
                                           name="permisos[]" 
                                           id="perm_{{ $permiso->PermisosID }}" 
                                           value="{{ $permiso->PermisosID }}"
                                           {{ $cargo->permisos->contains('PermisosID', $permiso->PermisosID) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_{{ $permiso->PermisosID }}">
                                        <span class="d-block fw-bold text-slate-800" style="font-size: 0.85rem;">
                                            {{ strtoupper($permiso->Nombrepermiso) }}
                                        </span>
                                        <small class="text-slate-500 d-block lh-sm" style="font-size: 0.75rem;">
                                            {{ $permiso->Descripcion ?? 'Permite acceder a funciones específicas del módulo.' }}
                                        </small>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .hover-shadow:hover { background-color: #fff !important; border-color: var(--upds-gold) !important; cursor: pointer; }
    .transition-all { transition: all 0.2s ease-in-out; }
</style>
@endsection