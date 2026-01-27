@extends('layouts.app')

@section('content')
<div class="sia-auth-wrapper animate__animated animate__fadeIn">
    
    {{-- Tarjeta de Login Compacta --}}
    <div class="sia-compact-card">
        
        {{-- Cabecera Tighter (Más estrecha) --}}
        <div class="sia-card-header-compact">
            <div class="logo-box">
                <i class="bi bi-mortarboard-fill text-upds-gold"></i>
            </div>
            <h5 class="text-white font-black tracking-tighter mb-0 mt-2">SIA V4.0</h5>
            <span class="text-white/40 text-[9px] font-bold uppercase tracking-widest">Portal de Acceso</span>
        </div>

        <div class="card-body p-4 p-md-5 bg-white">
            <div class="text-center mb-4">
                <h6 class="font-black text-upds-blue mb-1">Identificación Administrativa</h6>
                <p class="text-slate-400 text-[11px] font-medium">Ingrese sus credenciales del Vicerrectorado.</p>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                {{-- Input Email --}}
                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control sia-input @error('email') is-invalid @enderror" 
                           id="floatingInput" placeholder="nombre@upds.edu.bo" value="{{ old('email') }}" required autofocus>
                    <label for="floatingInput" class="text-slate-400">Correo Institucional</label>
                    @error('email')
                        <div class="invalid-feedback font-bold text-[10px]">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Input Password --}}
                <div class="input-group mb-4">
                    <div class="form-floating flex-grow-1">
                        <input type="password" name="password" class="form-control sia-input password-field @error('password') is-invalid @enderror" 
                               id="passwordInput" placeholder="Contraseña" required>
                        <label for="passwordInput" class="text-slate-400">Contraseña</label>
                    </div>
                    <span class="input-group-text sia-input-append" onclick="togglePassword()">
                        <i class="bi bi-eye text-slate-400" id="toggleIcon"></i>
                    </span>
                    @error('password')
                        <div class="invalid-feedback d-block font-bold text-[10px]">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 px-1">
                    <div class="form-check">
                        <input class="form-check-input sia-check" type="checkbox" name="remember" id="rememberCheck">
                        <label class="form-check-label text-[11px] font-bold text-slate-500" for="rememberCheck">
                            Recordarme
                        </label>
                    </div>
                </div>

                {{-- Botón de Acción --}}
                <button type="submit" class="btn btn-sia-primary-compact w-100">
                    <i class="bi bi-shield-lock-fill me-2"></i> INGRESAR
                </button>
            </form>
        </div>

        {{-- Footer Mini --}}
        <div class="py-3 bg-slate-50 border-t text-center">
            <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-0">
                UPDS Santa Cruz © {{ date('Y') }}
            </p>
        </div>
    </div>
</div>

<style>
    /* Estilos para el Login Compacto SIA V4.0 */
    .sia-auth-wrapper {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100vh;
        background: radial-gradient(circle at center, #0f172a 0%, #020617 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2000;
    }

    .sia-compact-card {
        width: 100%;
        max-width: 380px; /* Tamaño más compacto */
        background: white;
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
    }

    .sia-card-header-compact {
        background-color: var(--upds-blue);
        padding: 2rem 1rem;
        text-align: center;
        border-bottom: 4px solid var(--upds-gold);
    }

    .logo-box {
        font-size: 2.5rem;
        line-height: 1;
        filter: drop-shadow(0 4px 6px rgba(0,0,0,0.2));
    }

    .sia-input {
        border: 2px solid #f1f5f9 !important;
        background-color: #f8fafc !important;
        border-radius: 12px !important;
        font-size: 0.9rem !important;
        font-weight: 600 !important;
    }

    .sia-input:focus {
        border-color: var(--upds-gold) !important;
        background-color: white !important;
        box-shadow: 0 0 0 4px rgba(255, 195, 0, 0.1) !important;
    }

    .sia-input-append {
        background: #f8fafc;
        border: 2px solid #f1f5f9;
        border-left: none;
        border-radius: 0 12px 12px 0;
        cursor: pointer;
    }

    .btn-sia-primary-compact {
        background-color: var(--upds-blue);
        color: white;
        border: none;
        padding: 12px;
        border-radius: 12px;
        font-weight: 900;
        font-size: 0.8rem;
        letter-spacing: 1px;
        transition: all 0.3s;
    }

    .btn-sia-primary-compact:hover {
        background-color: var(--upds-blue-dark);
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
        color: white;
    }

    .sia-check:checked {
        background-color: var(--upds-gold);
        border-color: var(--upds-gold);
    }

    .font-black { font-weight: 900; }
    .tracking-tighter { letter-spacing: -0.05em; }
</style>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('passwordInput');
        const icon = document.getElementById('toggleIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script>
@endsection