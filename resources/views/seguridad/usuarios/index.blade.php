@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Encabezado de Módulo --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="h3 font-black text-slate-800 mb-1">Cuentas de Acceso</h2>
            <p class="text-slate-500 fw-medium small mb-0 text-uppercase tracking-wider">
                <i class="bi bi-shield-check me-1"></i> Administración de Seguridad (SEG-02)
            </p>
        </div>

        {{-- Buscador Inteligente --}}
        <div class="col-12 col-md-4">
            <form action="{{ route('usuarios.index') }}" method="GET">
                <div class="input-group shadow-sm">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-slate-400"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" 
                           placeholder="Buscar por usuario o correo..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary fw-bold px-4">Filtrar</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla de Registros --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-slate-50 border-bottom">
                        <tr>
                            <th class="ps-4 py-3 text-slate-600 font-bold small text-uppercase">Credenciales</th>
                            <th class="py-3 text-slate-600 font-bold small text-uppercase">Personal Asociado</th>
                            <th class="py-3 text-slate-600 font-bold small text-uppercase">Estado</th>
                            <th class="py-3 text-slate-600 font-bold small text-uppercase">Creación</th>
                            <th class="text-end pe-4 py-3 text-slate-600 font-bold small text-uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $user)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle bg-upds-blue text-white rounded-3 d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">
                                        {{ substr($user->NombreUsuario, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-slate-800">{{ $user->NombreUsuario }}</div>
                                        <div class="text-slate-500 small">{{ $user->Correo }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($user->personal)
                                    <div class="fw-semibold text-dark small">{{ $user->personal->Nombrecompleto }}</div>
                                    <span class="badge bg-light text-slate-600 border fw-medium" style="font-size: 0.7rem;">
                                        {{ $user->personal->cargo->Nombrecargo ?? 'Sin cargo' }}
                                    </span>
                                @else
                                    <span class="text-slate-400 small italic">Sin perfil vinculado</span>
                                @endif
                            </td>
                            <td>
                                @if($user->Activo)
                                    <span class="badge rounded-pill bg-success-subtle text-success px-3 border border-success-subtle">Activo</span>
                                @else
                                    <span class="badge rounded-pill bg-danger-subtle text-danger px-3 border border-danger-subtle">Bloqueado</span>
                                @endif
                            </td>
                            <td class="text-slate-500 small">
                                {{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    {{-- Botón Editar --}}
                                    <a href="{{ route('usuarios.edit', $user->UsuarioID) }}" 
                                       class="btn btn-sm btn-white border shadow-sm rounded-3" 
                                       title="Editar credenciales">
                                        <i class="bi bi-pencil-square text-primary"></i>
                                    </a>
                                    
                                    {{-- Botón Reset Password (SEG-02) --}}
                                    <form action="{{ route('usuarios.reset', $user->UsuarioID) }}" method="POST" 
                                          onsubmit="return confirm('¿Restablecer contraseña al número de CI para este usuario?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-white border shadow-sm rounded-3" 
                                                title="Restablecer contraseña al CI">
                                            <i class="bi bi-shield-lock text-warning"></i>
                                        </button>
                                    </form>

                                    {{-- Botón Toggle Estado --}}
                                    <form action="{{ route('usuarios.toggle', $user->UsuarioID) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $user->Activo ? 'btn-white border' : 'btn-danger' }} shadow-sm rounded-3" 
                                                title="{{ $user->Activo ? 'Bloquear acceso' : 'Activar acceso' }}">
                                            <i class="bi {{ $user->Activo ? 'bi-person-x text-danger' : 'bi-person-check text-white' }}"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-5 text-center">
                                <i class="bi bi-people text-slate-300 fs-1"></i>
                                <p class="text-slate-500 mt-2">No se encontraron cuentas de acceso registradas.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        {{-- Paginación UPDS Style --}}
        @if($usuarios->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $usuarios->links('vendor.pagination.bootstrap-5') }}
        </div>
        @endif
    </div>
</div>

<style>
    .avatar-circle { font-size: 0.9rem; letter-spacing: 0; }
    .btn-white { background: #fff; transition: all 0.2s; }
    .btn-white:hover { background: #f8fafc; transform: translateY(-1px); }
</style>
@endsection