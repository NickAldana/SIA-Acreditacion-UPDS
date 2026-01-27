@extends('layouts.app')

@section('content')
<div class="container-fluid py-2">
    
    {{-- ENCABEZADO --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-upds-blue mb-0">Directorio de Personal</h2>
            <p class="text-muted small uppercase tracking-wider">Gestión y control de acreditación docente</p>
        </div>
        @can('gestionar_personal')
        <a href="{{ route('personal.create') }}" class="btn btn-sia-primary rounded-pill shadow-sm px-4 fw-bold">
            <i class="bi bi-person-plus-fill me-2"></i> Nuevo Registro
        </a>
        @endcan
    </div>

    {{-- BARRA DE FILTROS AVANZADA --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border-top: 3px solid var(--upds-gold) !important;">
        <div class="card-body p-4">
            <form action="{{ route('personal.index') }}" method="GET" class="row g-3">
                
                {{-- 1. Búsqueda por texto --}}
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-upds-blue opacity-75">Búsqueda rápida</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-search text-upds-blue"></i></span>
                        <input type="text" name="buscar" class="form-control bg-light border-0" 
                               placeholder="Nombre o CI..." value="{{ request('buscar') }}">
                    </div>
                </div>

                {{-- 2. Filtro por Carrera --}}
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-upds-blue opacity-75">Carrera / Área</label>
                    <select name="carrera" class="form-select bg-light border-0">
                        <option value="">-- Todas las carreras --</option>
                        @foreach($carreras as $c)
                            <option value="{{ $c->IdCarrera }}" {{ request('carrera') == $c->IdCarrera ? 'selected' : '' }}>
                                {{ $c->NombreCarrera }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 3. Filtro por Estado --}}
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-upds-blue opacity-75">Filtrar por Estado</label>
                    <select name="estado" class="form-select bg-light border-0">
                        <option value="" {{ request('estado') === null ? 'selected' : '' }}>Mostrar Todos</option>
                        <option value="1" {{ request('estado') === '1' ? 'selected' : '' }}>Solo Activos</option>
                        <option value="0" {{ request('estado') === '0' ? 'selected' : '' }}>Solo Bajas</option>
                    </select>
                </div>

                {{-- 4. Botones --}}
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-sia-primary w-100 fw-bold">
                        <i class="bi bi-funnel-fill me-2"></i> Filtrar
                    </button>
                    <a href="{{ route('personal.index') }}" class="btn btn-light border" title="Limpiar Filtros">
                        <i class="bi bi-arrow-counterclockwise text-upds-blue"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLA DE RESULTADOS --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background-color: #f1f5f9;">
                    <tr class="extra-small fw-bold text-upds-blue uppercase tracking-widest">
                        <th class="ps-4 py-3">Nombre Completo</th>
                        <th class="py-3">Profesión / Especialidad</th>
                        <th class="py-3 text-center">Estado</th>
                        <th class="pe-4 py-3 text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($personal as $docente)
                        <tr>
                            {{-- Columna Nombre --}}
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-lg bg-sia-light text-upds-blue d-flex align-items-center justify-content-center me-3 border border-blue-100" style="width: 40px; height: 40px; font-weight: 800;">
                                        {{ substr($docente->NombreCompleto, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-upds-blue" style="font-size: 0.95rem;">{{ $docente->ApellidoPaterno }} {{ $docente->ApellidoMaterno }}, {{ $docente->NombreCompleto }}</div>
                                        <span class="text-muted extra-small font-mono">CI: {{ $docente->CI }}</span>
                                    </div>
                                </div>
                            </td>

                            {{-- Columna Profesión --}}
                            <td>
                                @php $formacion = $docente->formaciones->first(); @endphp
                                <span class="text-dark fw-medium" style="font-size: 0.85rem;">{{ $formacion->TituloObtenido ?? 'No registrada' }}</span>
                            </td>

                            {{-- Columna Estado --}}
                            <td class="text-center">
                                @if($docente->Activo)
                                    <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3">Activo</span>
                                @else
                                    <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3">Baja</span>
                                @endif
                            </td>

                            {{-- Columna Acciones --}}
                            <td class="pe-4 text-end">
                                <div class="btn-group shadow-sm rounded-3">
                                    <a href="{{ route('personal.show', $docente->IdPersonal) }}" class="btn btn-white btn-sm border" title="Ver Perfil">
                                        <i class="bi bi-eye-fill text-upds-blue"></i>
                                    </a>
                                    
                                    @can('gestionar_personal')
                                    <form action="{{ route('personal.toggle', $docente->IdPersonal) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-white btn-sm border" 
                                                onclick="return confirm('¿Cambiar estado de este registro?')"
                                                title="{{ $docente->Activo ? 'Dar de Baja' : 'Activar' }}">
                                            <i class="bi {{ $docente->Activo ? 'bi-person-x-fill text-danger' : 'bi-person-check-fill text-success' }}"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="py-5">
                                    <div class="mb-3">
                                        <i class="bi bi-funnel text-upds-blue opacity-10" style="font-size: 5rem;"></i>
                                    </div>
                                    @if(request()->anyFilled(['buscar', 'carrera', 'estado']))
                                        <h5 class="text-upds-blue fw-bold">Sin coincidencias</h5>
                                        <p class="text-muted small">Intente con otros criterios de búsqueda.</p>
                                    @else
                                        <h5 class="text-upds-blue fw-bold">Búsqueda Requerida</h5>
                                        <p class="text-muted small">Seleccione una carrera o ingrese un nombre para cargar la lista.</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINACIÓN --}}
        @if($personal instanceof \Illuminate\Pagination\LengthAwarePaginator && $personal->total() > 0)
            <div class="card-footer bg-white border-0 py-3">
                {{ $personal->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    /* Sincronización con variables del App Blade */
    .btn-sia-primary { 
        background-color: var(--upds-blue); 
        color: white; 
        border: none; 
        transition: var(--sia-transition);
    }
    .btn-sia-primary:hover { 
        background-color: var(--upds-blue-dark); 
        color: var(--upds-gold); 
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 53, 102, 0.2);
    }
    .bg-sia-light { background-color: rgba(0, 53, 102, 0.05); }
    .text-upds-blue { color: var(--upds-blue); }
    .extra-small { font-size: 0.7rem; }
    .btn-white:hover { background-color: var(--upds-gray-bg); }
    
    /* Ajuste de Paginación para que use colores UPDS */
    .pagination .page-item.active .page-link {
        background-color: var(--upds-blue);
        border-color: var(--upds-blue);
    }
    .pagination .page-link {
        color: var(--upds-blue);
    }
</style>
@endsection