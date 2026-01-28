@extends('layouts.app')

@section('content')
{{-- Carga de recursos específicos para mantener consistencia visual con el Welcome --}}
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    /* Configuración de Identidad Visual */
    :root {
        --upds-blue: #003566;
        --upds-gold: #ffc300;
        --slate-50: #f8fafc;
    }
    
    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--slate-50);
    }

    /* Patrón de Fondo Tecnológico (Igual al Welcome) */
    .login-bg-pattern {
        background-image: radial-gradient(#003566 0.5px, transparent 0.5px), radial-gradient(#003566 0.5px, #f8fafc 0.5px);
        background-size: 20px 20px;
        background-position: 0 0, 10px 10px;
        opacity: 0.05;
    }

    /* Tarjeta de Vidrio/Moderna */
    .login-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    }

    /* Inputs Personalizados */
    .modern-input {
        transition: all 0.3s ease;
        background-color: #f1f5f9; /* Slate 100 */
        border: 2px solid transparent;
    }
    .modern-input:focus {
        background-color: #ffffff;
        border-color: var(--upds-blue);
        box-shadow: 0 0 0 4px rgba(0, 53, 102, 0.1);
        outline: none;
    }

    /* Botón */
    .btn-login {
        background-image: linear-gradient(to right, var(--upds-blue), #004e92);
        transition: all 0.3s ease;
    }
    .btn-login:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 15px -3px rgba(0, 53, 102, 0.3);
    }
</style>

<div class="fixed inset-0 w-full h-full flex items-center justify-center p-4">
    
    {{-- Fondo Decorativo --}}
    <div class="absolute inset-0 login-bg-pattern z-0 pointer-events-none"></div>
    <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-blue-100/40 to-transparent z-0 pointer-events-none"></div>

    {{-- Tarjeta Principal --}}
    <div class="login-card w-full max-w-[400px] rounded-3xl overflow-hidden relative z-10 animate__animated animate__fadeInUp">
        
        {{-- Cabecera con Logo --}}
        <div class="text-center pt-10 pb-6 px-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-50 text-[#003566] mb-4 shadow-sm border border-blue-100">
                <i class="bi bi-mortarboard-fill text-3xl"></i>
            </div>
            
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Bienvenido</h2>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Plataforma SIA v4.0</p>
        </div>

        {{-- Formulario --}}
        <div class="px-8 pb-10">
            <form action="{{ route('login') }}" method="POST">
                @csrf

                {{-- Email --}}
                <div class="mb-5">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">
                        Credencial Institucional
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="bi bi-envelope-fill text-slate-400 group-focus-within:text-[#003566] transition-colors"></i>
                        </div>
                        <input type="email" name="email" 
                               class="modern-input w-full pl-11 pr-4 py-3.5 rounded-xl text-sm font-semibold text-slate-700 placeholder-slate-400" 
                               placeholder="usuario@upds.net.bo" 
                               value="{{ old('email') }}" required autofocus>
                    </div>
                    @error('email')
                        <span class="text-red-500 text-[10px] font-bold mt-1 block ml-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">
                        Contraseña
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="bi bi-key-fill text-slate-400 group-focus-within:text-[#003566] transition-colors"></i>
                        </div>
                        <input type="password" name="password" id="passwordInput"
                               class="modern-input w-full pl-11 pr-12 py-3.5 rounded-xl text-sm font-semibold text-slate-700 placeholder-slate-400" 
                               placeholder="••••••••" required>
                        
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer">
                            <i class="bi bi-eye-fill" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="text-red-500 text-[10px] font-bold mt-1 block ml-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Recordarme + Botón --}}
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-[#003566] focus:ring-[#003566]">
                        <span class="ml-2 text-xs font-bold text-slate-500">Mantener sesión</span>
                    </label>
                    <a href="#" class="text-xs font-bold text-[#003566] hover:text-[#ffc300] transition-colors">
                        ¿Problemas?
                    </a>
                </div>

                <button type="submit" class="btn-login w-full py-4 rounded-xl text-white font-bold text-sm tracking-wide shadow-lg shadow-blue-900/20 relative overflow-hidden group">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        INGRESAR AL SISTEMA <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </button>

            </form>
        </div>

        {{-- Footer Tarjeta --}}
        <div class="bg-slate-50 border-t border-slate-100 p-4 text-center">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                <i class="bi bi-shield-check text-green-500 mr-1"></i> Conexión Segura UPDS
            </p>
        </div>
    </div>
    
    {{-- Footer Copyright --}}
    <div class="absolute bottom-6 text-center w-full">
        <p class="text-[10px] font-medium text-slate-400">
            &copy; {{ date('Y') }} Universidad Privada Domingo Savio. Todos los derechos reservados.
        </p>
    </div>

</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('passwordInput');
        const icon = document.getElementById('toggleIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
        } else {
            passwordInput.type = 'password';
            icon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
        }
    }
</script>
@endsection