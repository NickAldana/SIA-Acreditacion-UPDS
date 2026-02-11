<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIA - UPDS Santa Cruz</title>
    
    {{-- Scripts y Estilos Core --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    {{-- Tipografía --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        /* Variables de Identidad UPDS */
        :root {
            --upds-blue: #003566;
            --upds-blue-dark: #001d3d;
            --upds-blue-light: #00509d;
            --upds-gold: #ffc300;
            --upds-gray-bg: #f8fafc;
            --sia-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            background-color: var(--upds-gray-bg);
            letter-spacing: -0.01em;
            font-family: 'Inter', system-ui, sans-serif;
            color: #1e293b; 
            -webkit-font-smoothing: antialiased;
        }

        [x-cloak] { display: none !important; }

        /* Estilos de Navegación */
        .sia-nav-sidebar {
            background-color: var(--upds-blue) !important;
            background-image: linear-gradient(180deg, var(--upds-blue) 0%, var(--upds-blue-dark) 100%);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sia-nav-link {
            color: rgba(255, 255, 255, 0.95) !important; /* Letra más clara */
            transition: var(--sia-transition);
            border-radius: 8px;
            display: flex;
            align-items: center;
            padding: 12px 14px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            margin-bottom: 4px;
        }

        .sia-nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            transform: translateX(4px);
        }

        .sia-nav-link-active {
            background-color: var(--upds-gold) !important;
            color: var(--upds-blue) !important;
            font-weight: 800 !important;
            box-shadow: 0 4px 12px rgba(255, 195, 0, 0.3);
        }

        .sia-submenu-link {
            padding-left: 2.5rem;
            font-size: 0.85rem;
            opacity: 0.95 !important;
        }
        
        .sia-header {
            background-color: white;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            height: 80px;
        }

        .sia-core-scrollbar::-webkit-scrollbar { width: 5px; }
        .sia-core-scrollbar::-webkit-scrollbar-thumb { 
            background: rgba(255, 255, 255, 0.2); 
            border-radius: 10px; 
        }

        /* Color Oro personalizado para el cargo */
        .text-upds-gold { color: var(--upds-gold) !important; }
    </style>
</head>

<body class="h-screen overflow-hidden flex" x-data="{ sidebarOpen: true }">

    @auth
    {{-- SIDEBAR --}}
    <aside x-show="sidebarOpen" 
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           class="hidden md:flex md:w-72 md:flex-col md:fixed md:inset-y-0 sia-nav-sidebar z-20 shadow-2xl shrink-0" x-cloak>
        
        <div class="flex flex-col flex-grow pt-6 overflow-y-auto sia-core-scrollbar px-4">
            
            <div class="flex items-center flex-shrink-0 mb-8 mt-2 px-2">
                <i class="bi bi-mortarboard-fill text-upds-gold fs-1 me-3"></i>
                <div>
                    <span class="block text-white font-black text-2xl tracking-tighter leading-none">SIA</span>
                    <span class="text-blue-200/80 text-[10px] font-bold uppercase tracking-widest">Acreditación V4.0</span>
                </div>
            </div>

            {{-- TARJETA DE USUARIO CORREGIDA --}}
            <div class="mb-8 px-2">
                <div class="bg-[#002855] rounded-2xl p-3 border border-white/10 shadow-lg relative group overflow-hidden">
                    <div class="flex items-center gap-3 relative z-10">
                        <div class="relative shrink-0">
                            <div class="w-10 h-10 rounded-lg bg-white p-0.5 shadow-sm">
                                @if(auth()->user()->personal && auth()->user()->personal->Fotoperfil)
                                    <img class="w-full h-full rounded-md object-cover" 
                                         src="{{ asset('storage/' . auth()->user()->personal->Fotoperfil) }}?v={{ time() }}" 
                                         alt="Avatar">
                                @else
                                    <img class="w-full h-full rounded-md object-cover" 
                                         src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->personal->Nombrecompleto ?? 'U') }}&background=ffc300&color=003566&bold=true" 
                                         alt="Avatar">
                                @endif
                            </div>
                            <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 border-2 border-[#002855] rounded-full"></span>
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-white leading-tight mb-1 truncate">
                                {{ auth()->user()->personal ? explode(' ', auth()->user()->personal->Nombrecompleto)[0] : 'Usuario' }}
                            </p>
                            {{-- CAMBIO AQUÍ: Color de cargo forzado a UPDS GOLD y lectura completa --}}
                            <p class="text-[10px] font-black text-upds-gold uppercase tracking-wider whitespace-normal leading-tight shadow-sm">
                                {{ auth()->user()->personal->cargo->Nombrecargo ?? 'INVITADO' }}
                            </p>
                        </div>

                        <div class="self-start">
                            <a href="{{ route('profile.edit') }}" class="text-slate-400 hover:text-white transition-colors">
                                <i class="bi bi-gear-fill text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <nav class="flex-1 space-y-1">
                <p class="px-2 text-[10px] font-black text-blue-300/50 uppercase tracking-widest mb-2 mt-2">Plataforma</p>
                <a href="{{ route('dashboard') }}" class="sia-nav-link {{ request()->routeIs('dashboard') ? 'sia-nav-link-active' : '' }}">
                    <i class="bi bi-grid-1x2-fill mr-3"></i> Panel de Control
                </a>

                @canany(['gestion_personal', 'gestion_academica'])
                <p class="px-2 text-[10px] font-black text-blue-300/50 uppercase tracking-widest mb-2 mt-4">Gestión Académica</p>
                @can('gestion_personal') 
                <a href="{{ route('personal.index') }}" class="sia-nav-link {{ request()->routeIs('personal.*') ? 'sia-nav-link-active' : '' }}">
                    <i class="bi bi-people-fill mr-3"></i> Directorio Personal
                </a>
                @endcan
                @can('gestion_academica')
                <a href="{{ route('carga.create') }}" class="sia-nav-link {{ request()->routeIs('carga.*') ? 'sia-nav-link-active' : '' }}">
                    <i class="bi bi-calendar-check-fill mr-3"></i> Asignación Materias
                </a>
                @endcan
                @endcanany

                @canany(['gestion_investigacion', 'subir_archivos'])
                <p class="px-2 text-[10px] font-black text-blue-300/50 uppercase tracking-widest mb-2 mt-4">Investigación</p>
                <a href="{{ route('investigacion.index') }}" 
                   class="sia-nav-link {{ request()->routeIs('investigacion.*') || request()->routeIs('publicaciones.*') || request()->routeIs('presupuesto.*') ? 'sia-nav-link-active' : '' }}">
                    <i class="bi bi-journal-bookmark-fill mr-3"></i> Producción Científica
                </a>
                @endcanany
        
                @can('ver_dashboard_bi')
                <p class="px-2 text-[10px] font-black text-blue-300/50 uppercase tracking-widest mb-2 mt-4">Intelligence</p>
                <a href="{{ route('analitica.acreditacion') }}" class="sia-nav-link {{ request()->routeIs('analitica.*') ? 'sia-nav-link-active' : '' }}">
                    <i class="bi bi-graph-up-arrow mr-3"></i> Indicadores Docente
                </a>
                @endcan

                @can('acceso_total')
                <div x-data="{ openAdmin: {{ request()->routeIs('usuarios.*') || request()->routeIs('cargos.*') || request()->routeIs('permisos.*') ? 'true' : 'false' }} }">
                    <p class="px-2 text-[10px] font-black text-blue-300/50 uppercase tracking-widest mb-2 mt-4">Administración</p>
                    <button @click="openAdmin = !openAdmin" 
                            class="sia-nav-link w-full justify-between group {{ request()->routeIs('usuarios.*') || request()->routeIs('cargos.*') || request()->routeIs('permisos.*') ? 'text-white font-bold' : '' }}">
                        <div class="flex items-center">
                            <i class="bi bi-shield-lock-fill mr-3 text-red-400"></i> Seguridad
                        </div>
                        <i class="bi bi-chevron-down text-[10px]" :class="openAdmin ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openAdmin" x-cloak class="mt-1 space-y-1">
                        <a href="{{ route('usuarios.index') }}" class="sia-nav-link sia-submenu-link {{ request()->routeIs('usuarios.*') ? 'text-white font-bold bg-white/10' : '' }}">Usuarios</a>
                        <a href="{{ route('cargos.index') }}" class="sia-nav-link sia-submenu-link {{ request()->routeIs('cargos.*') ? 'text-white font-bold bg-white/10' : '' }}">Cargos</a>
                        <a href="{{ route('permisos.index') }}" class="sia-nav-link sia-submenu-link {{ request()->routeIs('permisos.*') ? 'text-white font-bold bg-white/10' : '' }}">Permisos</a>
                    </div>
                </div>
                @endcan
            </nav>

            <div class="py-6 mt-auto">
                <div class="text-center">
                    <p class="text-[9px] text-blue-300/40 font-mono">UPDS SCZ © {{ date('Y') }}</p>
                </div>
            </div>
        </div>
    </aside>

    {{-- CONTENIDO --}}
    <div class="flex flex-col flex-1 h-screen transition-all duration-300 bg-slate-50 w-full" :class="sidebarOpen ? 'md:pl-72' : 'md:pl-0'">
        <header class="sia-header flex px-8 items-center justify-between shrink-0 sticky top-0 z-20">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="text-slate-500 hover:text-upds-blue p-2 rounded-lg hover:bg-slate-100">
                    <i class="bi bi-list text-2xl"></i>
                </button>
                <div class="hidden sm:block">
                    <h1 class="text-xl font-black text-slate-800 tracking-tight capitalize leading-none">{{ request()->segment(1) ?? 'Dashboard' }}</h1>
                    <p class="text-[11px] text-slate-500 font-bold uppercase tracking-wider mt-1">Sistema de Gestión Integrado</p>
                </div>
            </div>

            <div class="flex items-center gap-6">
                <div class="hidden md:flex flex-col items-end">
                    <span class="text-xs font-bold text-slate-700">{{ date('d M, Y') }}</span>
                </div>
                <div class="h-8 w-px bg-slate-200"></div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold text-red-600 bg-red-50 hover:bg-red-600 hover:text-white transition-all border border-red-100">
                        <i class="bi bi-power fs-6"></i><span>Salir</span>
                    </button>
                </form>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 sia-core-scrollbar bg-slate-50">
            <div class="max-w-7xl mx-auto pb-10">
                @yield('content')
            </div>
        </main>
    </div>

    @else
    <div class="w-full h-full flex items-center justify-center p-4 bg-slate-100">
        @yield('content')
    </div>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>