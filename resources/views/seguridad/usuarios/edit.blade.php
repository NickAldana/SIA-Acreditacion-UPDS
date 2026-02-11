@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px;">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
            <li class="breadcrumb-item active">Editar Credenciales</li>
        </ol>
    </nav>

    <div class="card border-0 shadow-sm mt-3">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Actualizar Cuenta: {{ $usuario->NombreUsuario }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('usuarios.update', $usuario->UsuarioID) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label text-muted small uppercase fw-bold">Correo Institucional</label>
                    <input type="email" name="Correo" class="form-control @error('Correo') is-invalid @enderror" value="{{ old('Correo', $usuario->Correo) }}" required>
                    @error('Correo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <hr class="my-4">

                <div class="bg-light p-3 rounded mb-3">
                    <p class="small text-muted mb-2"><i class="bi bi-info-circle me-1"></i> Deje los campos de contraseña vacíos si no desea cambiarlos.</p>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nueva Contraseña</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-bold">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary py-2">Guardar Cambios</button>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-link text-muted">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection