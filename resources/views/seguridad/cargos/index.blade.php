@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 font-black text-slate-800 mb-1">Estructura de Cargos</h2>
            <p class="text-slate-500 fw-medium small mb-0 text-uppercase tracking-wider">
                <i class="bi bi-diagram-3-fill me-1"></i> Gestión de Roles y Jerarquías (SEG-03 / SEG-04)
            </p>
        </div>
        <a href="{{ route('cargos.create') }}" class="btn btn-primary fw-bold px-4 shadow-sm">
            <i class="bi bi-plus-lg me-2"></i> Nuevo Cargo
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-slate-50 border-bottom">
                        <tr>
                            <th class="ps-4 py-3 text-slate-600 font-bold small text-uppercase">Nombre del Cargo</th>
                            <th class="py-3 text-slate-600 font-bold small text-uppercase">Nivel Jerárquico</th>
                            <th class="py-3 text-slate-600 font-bold small text-uppercase text-center">Permisos Asignados</th>
                            <th class="text-end pe-4 py-3 text-slate-600 font-bold small text-uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cargos as $cargo)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-slate-800">{{ $cargo->Nombrecargo }}</div>
                                <div class="text-slate-400 small">ID: #{{ $cargo->CargoID }}</div>
                            </td>
                            <td>
                                <span class="badge {{ $cargo->nivel_jerarquico == 1 ? 'bg-danger' : ($cargo->nivel_jerarquico == 2 ? 'bg-warning text-dark' : 'bg-info') }} rounded-pill px-3">
                                    {{ $cargo->nivel_legible }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex align-items-center justify-content-center bg-slate-100 rounded-circle fw-bold text-upds-blue" style="width: 35px; height: 35px;">
                                    {{ $cargo->permisos_count }}
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('cargos.edit', $cargo->CargoID) }}" 
                                   class="btn btn-sm btn-outline-primary border-2 fw-bold rounded-3 px-3" 
                                   title="Configurar Matriz de Permisos">
                                    <i class="bi bi-shield-lock-fill me-1"></i> Matriz
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection