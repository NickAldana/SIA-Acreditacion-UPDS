<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIA UPDS | Modelo AgileQ++</title>
    
    {{-- TAILWIND CSS (Versión CDN para diseño moderno instantáneo) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- FUENTE INTER (Estándar en diseño de interfaces modernas) --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    {{-- ICONOS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        upds: {
                            blue: '#003566',
                            dark: '#001d36',
                            gold: '#ffc300',
                            light: '#f0f4f8'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        /* Efectos de Vidrio y Gradientes */
        .glass-panel {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 8px 32px rgba(0, 53, 102, 0.08);
        }
        .hero-pattern {
            background-color: #ffffff;
            background-image: radial-gradient(#003566 0.5px, transparent 0.5px), radial-gradient(#003566 0.5px, #ffffff 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            opacity: 0.03;
        }
        .text-gradient {
            background: linear-gradient(to right, #003566, #0056b3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        /* Animación suave de entrada */
        @keyframes floatUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-enter {
            animation: floatUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }
    </style>
</head>
<body class="font-sans text-slate-600 antialiased selection:bg-upds-gold selection:text-upds-blue bg-slate-50">

    {{-- FONDO DECORATIVO --}}
    <div class="fixed inset-0 hero-pattern z-0 pointer-events-none"></div>
    <div class="fixed top-0 right-0 w-2/3 h-full bg-gradient-to-l from-blue-50/50 to-transparent z-0 pointer-events-none"></div>

    {{-- NAVBAR --}}
    <nav class="fixed w-full z-50 transition-all duration-300 bg-white/80 backdrop-blur-md border-b border-slate-200/60">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                {{-- LOGO --}}
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-upds-blue text-upds-gold flex items-center justify-center rounded-xl shadow-lg shadow-blue-900/20">
                        <i class="bi bi-mortarboard-fill text-xl"></i>
                    </div>
                    <div class="leading-tight">
                        <span class="block font-black text-upds-blue text-lg tracking-tight">SIA <span class="text-upds-gold">.</span></span>
                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">UPDS Santa Cruz</span>
                    </div>
                </div>

                {{-- MENÚ ESCRITORIO --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="#modelo" class="text-sm font-semibold text-slate-600 hover:text-upds-blue transition-colors">Modelo AgileQ++</a>
                    <a href="#indicadores" class="text-sm font-semibold text-slate-600 hover:text-upds-blue transition-colors">Indicadores</a>
                    
                    {{-- BOTÓN ACCESO --}}
                    <a href="{{ route('login') }}" class="group relative inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-white transition-all duration-200 bg-upds-blue font-pj rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-upds-blue hover:bg-upds-dark shadow-md hover:shadow-lg">
                        <span class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-gradient-to-b from-transparent via-transparent to-black"></span>
                        <span class="relative flex items-center gap-2">
                            Acceso al Sistema <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <main class="relative z-10 pt-32 pb-16 lg:pt-48 lg:pb-32">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-16 items-center">
                
                {{-- COLUMNA IZQUIERDA: TEXTO --}}
                <div class="lg:col-span-6 animate-enter">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-100 text-upds-blue text-xs font-bold uppercase tracking-wider mb-6">
                        <span class="w-2 h-2 rounded-full bg-upds-gold animate-pulse"></span>
                        Vicerrectorado Académico
                    </div>
                    
                    <h1 class="text-5xl lg:text-7xl font-black text-slate-900 leading-tight tracking-tight mb-6">
                        Modelo <br>
                        <span class="text-gradient">AgileQ++</span>
                    </h1>
                    
                    <p class="text-xl text-slate-600 mb-8 leading-relaxed font-medium">
                        Gestión estratégica de indicadores para la <span class="text-upds-blue font-bold decoration-upds-gold underline decoration-4 underline-offset-4">Acreditación y Calidad Educativa</span>. Toma de decisiones basada en evidencia.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-8 py-4 text-base font-bold text-upds-blue bg-upds-gold rounded-2xl hover:bg-yellow-400 transition-all shadow-lg hover:shadow-xl hover:-translate-y-1">
                            <i class="bi bi-grid-fill mr-2"></i> Explorar Plataforma
                        </a>
                        <a href="#features" class="inline-flex justify-center items-center px-8 py-4 text-base font-bold text-slate-600 bg-white border border-slate-200 rounded-2xl hover:bg-slate-50 transition-all hover:border-slate-300">
                            Ver Documentación
                        </a>
                    </div>

                    <div class="mt-12 flex items-center gap-4 text-sm font-medium text-slate-500">
                        <div class="flex -space-x-2">
                            <div class="w-8 h-8 rounded-full bg-slate-200 border-2 border-white flex items-center justify-center text-xs">AI</div>
                            <div class="w-8 h-8 rounded-full bg-slate-300 border-2 border-white flex items-center justify-center text-xs">BI</div>
                            <div class="w-8 h-8 rounded-full bg-slate-400 border-2 border-white flex items-center justify-center text-xs">QS</div>
                        </div>
                        <p>Validado por estándares internacionales</p>
                    </div>
                </div>

                {{-- COLUMNA DERECHA: DASHBOARD PREVIEW (Estilo Figma) --}}
                <div class="lg:col-span-6 relative perspective-1000 animate-enter" style="animation-delay: 0.2s">
                    
                    {{-- Elementos Decorativos de Fondo --}}
                    <div class="absolute -top-12 -right-12 w-64 h-64 bg-upds-gold/20 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-12 -left-12 w-64 h-64 bg-upds-blue/10 rounded-full blur-3xl"></div>

                    {{-- CONTENEDOR PRINCIPAL DEL MOCKUP --}}
                    <div class="relative glass-panel rounded-3xl p-6 transform rotate-y-6 hover:rotate-0 transition-transform duration-500 ease-out">
                        
                        {{-- Mockup Header --}}
                        <div class="flex justify-between items-center mb-8 border-b border-slate-100 pb-4">
                            <div>
                                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Reporte en tiempo real</div>
                                <div class="text-lg font-bold text-slate-800">Desempeño Académico</div>
                            </div>
                            <div class="flex gap-2">
                                <span class="w-3 h-3 rounded-full bg-red-400"></span>
                                <span class="w-3 h-3 rounded-full bg-yellow-400"></span>
                                <span class="w-3 h-3 rounded-full bg-green-400"></span>
                            </div>
                        </div>

                        {{-- Mockup Widgets Grid --}}
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            {{-- Widget 1 --}}
                            <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-upds-blue flex items-center justify-center">
                                        <i class="bi bi-people-fill"></i>
                                    </div>
                                    <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded">+12%</span>
                                </div>
                                <div class="text-2xl font-black text-slate-800">92%</div>
                                <div class="text-xs text-slate-500 font-medium">Retención Estudiantil</div>
                            </div>

                            {{-- Widget 2 --}}
                            <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="w-8 h-8 rounded-lg bg-yellow-50 text-yellow-600 flex items-center justify-center">
                                        <i class="bi bi-award-fill"></i>
                                    </div>
                                    <span class="text-xs font-bold text-slate-400">Anual</span>
                                </div>
                                <div class="text-2xl font-black text-slate-800">4.8</div>
                                <div class="text-xs text-slate-500 font-medium">Índice de Calidad</div>
                            </div>
                        </div>

                        {{-- Mockup Chart Area --}}
                        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                            <div class="flex justify-between items-center mb-4">
                                <div class="text-xs font-bold text-slate-600">Proyección de Acreditación</div>
                                <div class="text-[10px] font-bold text-upds-blue bg-blue-100 px-2 py-0.5 rounded">META 2026</div>
                            </div>
                            <div class="h-24 flex items-end justify-between gap-2">
                                <div class="w-full bg-upds-blue/10 rounded-t-sm h-[40%]"></div>
                                <div class="w-full bg-upds-blue/20 rounded-t-sm h-[60%]"></div>
                                <div class="w-full bg-upds-blue/40 rounded-t-sm h-[50%]"></div>
                                <div class="w-full bg-upds-blue/60 rounded-t-sm h-[75%]"></div>
                                <div class="w-full bg-upds-blue rounded-t-sm h-[90%] relative group cursor-pointer">
                                    <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                        Objetivo Cumplido
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Floating Badge --}}
                        <div class="absolute -right-6 top-1/2 bg-white p-4 rounded-2xl shadow-xl border border-slate-100 flex items-center gap-3 animate-bounce" style="animation-duration: 3s;">
                            <div class="bg-green-500 w-2 h-2 rounded-full animate-ping"></div>
                            <div>
                                <div class="text-xs font-bold text-slate-800">Sincronización</div>
                                <div class="text-[10px] text-slate-500">Datos actualizados hace 2m</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- SECCIÓN DE CARACTERÍSTICAS (Grid Limpio) --}}
    <section class="py-24 bg-white border-t border-slate-100" id="features">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-3xl font-black text-slate-900 mb-4">Arquitectura de Datos Institucional</h2>
                <p class="text-slate-500">El modelo AgileQ++ integra múltiples fuentes de información para generar una visión holística del desempeño universitario.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                {{-- Feature 1 --}}
                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:border-upds-gold hover:bg-white hover:shadow-xl transition-all duration-300 group">
                    <div class="w-12 h-12 bg-white rounded-2xl shadow-sm border border-slate-100 flex items-center justify-center text-upds-blue text-xl mb-6 group-hover:bg-upds-blue group-hover:text-white transition-colors">
                        <i class="bi bi-diagram-3-fill"></i>
                    </div>
                    <h3 class="font-bold text-xl text-slate-900 mb-3">Gestión de Procesos</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Automatización de flujos de trabajo académicos y administrativos, reduciendo la carga operativa.
                    </p>
                </div>

                {{-- Feature 2 --}}
                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:border-upds-gold hover:bg-white hover:shadow-xl transition-all duration-300 group">
                    <div class="w-12 h-12 bg-white rounded-2xl shadow-sm border border-slate-100 flex items-center justify-center text-upds-blue text-xl mb-6 group-hover:bg-upds-blue group-hover:text-white transition-colors">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <h3 class="font-bold text-xl text-slate-900 mb-3">Analítica Predictiva</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Algoritmos que anticipan tendencias en retención y rendimiento estudiantil para intervenir a tiempo.
                    </p>
                </div>

                {{-- Feature 3 --}}
                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:border-upds-gold hover:bg-white hover:shadow-xl transition-all duration-300 group">
                    <div class="w-12 h-12 bg-white rounded-2xl shadow-sm border border-slate-100 flex items-center justify-center text-upds-blue text-xl mb-6 group-hover:bg-upds-blue group-hover:text-white transition-colors">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h3 class="font-bold text-xl text-slate-900 mb-3">Acreditación Continua</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Repositorio digital de evidencias alineado con los estándares de evaluación de la calidad.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER SIMPLE --}}
    <footer class="bg-upds-blue text-white py-12 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <i class="bi bi-mortarboard-fill text-upds-gold text-2xl"></i>
                <span class="font-bold text-lg tracking-tight">SIA UPDS <span class="text-white/50 font-normal text-sm">v4.0</span></span>
            </div>
            <p class="text-sm text-blue-200">
                &copy; {{ date('Y') }} Universidad Privada Domingo Savio. Todos los derechos reservados.
            </p>
        </div>
    </footer>

</body>
</html>