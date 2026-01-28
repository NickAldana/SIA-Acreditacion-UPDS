<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIA UPDS | Modelo AgileQ++</title>
    
    {{-- TAILWIND CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- FUENTES Y ICONOS --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
                            gray: '#f3f4f6'
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
        /* Vidrio Esmerilado para el Nav */
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 53, 102, 0.08);
        }
        
        /* Patrón de Fondo Hero */
        .hero-bg {
            background-color: #f8fafc;
            background-image: radial-gradient(#003566 0.5px, transparent 0.5px);
            background-size: 24px 24px;
            opacity: 0.6;
        }

        /* Gradientes y Efectos */
        .text-gold-gradient {
            background: linear-gradient(to right, #b4860b, #ffc300);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        /* Animaciones */
        .fade-up {
            animation: fadeUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }
        .delay-200 { animation-delay: 0.2s; }
    </style>
</head>
<body class="font-sans text-slate-600 antialiased selection:bg-upds-gold selection:text-upds-blue bg-white">

    {{-- NAVBAR --}}
    <nav class="fixed w-full z-50 glass-nav transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-24">
                {{-- LOGO --}}
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-upds-blue text-upds-gold flex items-center justify-center rounded-xl shadow-lg">
                        <i class="bi bi-mortarboard-fill text-2xl"></i>
                    </div>
                    <div class="leading-tight">
                        <span class="block font-black text-upds-blue text-xl tracking-tight">UPDS</span>
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-widest">AgileQ++</span>
                    </div>
                </div>

                {{-- MENÚ --}}
                <div class="hidden lg:flex items-center gap-10">
                    <a href="#inicio" class="text-sm font-bold text-slate-600 hover:text-upds-blue transition-colors">Inicio</a>
                    <a href="#modelo" class="text-sm font-bold text-slate-600 hover:text-upds-blue transition-colors">Modelo</a>
                    <a href="#acreditacion" class="text-sm font-bold text-slate-600 hover:text-upds-blue transition-colors">Acreditación</a>
                    <a href="#indicadores" class="text-sm font-bold text-slate-600 hover:text-upds-blue transition-colors">Indicadores</a>
                </div>

                {{-- ACCIONES --}}
                <div class="flex items-center gap-6">
                    <div class="hidden md:block text-right">
                        <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Gestión Estratégica</span>
                        <span class="block text-xs font-bold text-upds-blue">Vicerrectorado Académico</span>
                    </div>
                    <a href="{{ route('login') }}" class="group relative inline-flex items-center justify-center px-8 py-3 text-sm font-bold text-white transition-all duration-200 bg-upds-blue rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-upds-blue hover:bg-upds-dark shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                        Acceso al Sistema
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <header id="inicio" class="relative pt-40 pb-24 lg:pt-52 lg:pb-40 overflow-hidden">
        <div class="absolute inset-0 hero-bg -z-10"></div>
        
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-20 items-center">
                
                {{-- Contenido Izquierdo --}}
                <div class="fade-up">
                    <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-white border border-blue-100 text-upds-blue text-xs font-bold uppercase tracking-wider mb-8 shadow-sm">
                        <span class="relative flex h-2.5 w-2.5">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                        </span>
                        Gestión Estratégica Universitaria
                    </div>
                    
                    <h1 class="text-6xl lg:text-7xl font-black text-slate-900 leading-[1.05] mb-8 tracking-tight">
                        Modelo <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-upds-blue via-blue-700 to-upds-blue">AgileQ++</span>
                    </h1>
                    
                    <p class="text-xl text-slate-600 mb-10 leading-relaxed max-w-xl font-medium">
                        Optimización y monitoreo de <strong>indicadores de tercera generación</strong> para la excelencia académica y procesos de acreditación internacional basados en evidencia.
                    </p>

                    <div class="flex flex-wrap gap-4 mb-10">
                        <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-lg border border-slate-200 shadow-sm text-sm font-bold text-slate-700">
                            <i class="bi bi-database-fill text-upds-gold"></i> Big Data
                        </div>
                        <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-lg border border-slate-200 shadow-sm text-sm font-bold text-slate-700">
                            <i class="bi bi-award-fill text-upds-gold"></i> Calidad
                        </div>
                        <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-lg border border-slate-200 shadow-sm text-sm font-bold text-slate-700">
                            <i class="bi bi-graph-up-arrow text-upds-gold"></i> Investigación
                        </div>
                    </div>

                    {{-- BOTÓN PRINCIPAL --}}
                    <div class="flex gap-4 mb-12">
                        <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-8 py-4 text-base font-bold text-upds-blue bg-upds-gold rounded-xl hover:bg-yellow-400 transition-all shadow-lg hover:shadow-xl hover:-translate-y-1">
                            <i class="bi bi-lightning-charge-fill mr-2"></i> Comenzar Gestión
                        </a>
                    </div>

                    {{-- VALIDACIÓN (MovidA AQUÍ) --}}
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Avalado por Entidades Reguladoras</p>
                        <div class="flex items-center gap-8 opacity-90 hover:opacity-100 transition-opacity">
                            
                            {{-- CIEES --}}
                            <div class="group flex items-center gap-3 bg-white/50 px-4 py-2 rounded-xl border border-slate-100 hover:bg-white hover:shadow-md transition-all cursor-default">
                                <img src="https://www.upds.edu.bo/wp-content/uploads/2025/02/26-02-1-1.jpg" 
                                     alt="CIEES" 
                                     class="h-10 w-auto object-contain hover:scale-105 transition-transform">
                                <div class="leading-none">
                                    <span class="block text-[9px] font-bold text-slate-400 uppercase"></span>
                                    <span class="block text-xs font-black text-slate-700"></span>
                                </div>
                            </div>

                            {{-- MERCOSUR --}}
                            <div class="group flex items-center gap-3 bg-white/50 px-4 py-2 rounded-xl border border-slate-100 hover:bg-white hover:shadow-md transition-all cursor-default">
                                <img src="https://th.bing.com/th/id/R.d911541c12c23fc91ee8d2095929fa16?rik=BFeAp6NyxuRXag&riu=http%3a%2f%2fwww.bnm.me.gov.ar%2fnovedades%2fwp-content%2fuploads%2f2016%2f04%2fmercosur_educativo-150x134.png&ehk=OxzSWHtpZC7loQksczR9dHF433mC1ixxCCo0M1nEgps%3d&risl=&pid=ImgRaw&r=0" 
                                     alt="MERCOSUR" 
                                     class="h-10 w-auto object-contain hover:scale-105 transition-transform">
                                <div class="leading-none">
                                    <span class="block text-[9px] font-bold text-slate-400 uppercase"></span>
                                    <span class="block text-xs font-black text-slate-700"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Contenido Derecho: DASHBOARD MOCKUP --}}
                <div class="relative fade-up delay-200 hidden lg:block">
                    {{-- Decoración de fondo --}}
                    <div class="absolute -inset-1 bg-gradient-to-r from-upds-gold via-orange-300 to-upds-blue rounded-3xl blur opacity-30"></div>
                    
                    <div class="relative bg-white rounded-2xl border border-slate-200 shadow-2xl p-8">
                        {{-- Header Dashboard --}}
                        <div class="flex justify-between items-start mb-8 border-b border-slate-100 pb-6">
                            <div>
                                <h3 class="text-lg font-bold text-slate-800">Tablero de Control</h3>
                                <p class="text-xs font-medium text-slate-400 mt-1">Gestión Académica 1-2026</p>
                            </div>
                            <div class="flex items-center gap-2 bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                <span class="text-[10px] font-black text-green-600 uppercase tracking-wide">En Línea</span>
                                <span class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></span>
                            </div>
                        </div>

                        {{-- Stats Grid --}}
                        <div class="grid grid-cols-2 gap-6 mb-8">
                            <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                                <div class="flex justify-between mb-2">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Carga Académica</p>
                                    <i class="bi bi-cpu text-upds-blue opacity-50"></i>
                                </div>
                                <p class="text-3xl font-black text-upds-blue">94.2%</p>
                                <div class="w-full bg-slate-200 h-1.5 mt-3 rounded-full overflow-hidden">
                                    <div class="bg-upds-blue h-full w-[94.2%] rounded-full"></div>
                                </div>
                            </div>
                            <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                                <div class="flex justify-between mb-2">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Acreditación</p>
                                    <i class="bi bi-shield-check text-upds-gold"></i>
                                </div>
                                <p class="text-3xl font-black text-slate-800">A+</p>
                                <p class="text-[10px] font-bold text-green-600 mt-1 flex items-center gap-1">
                                    <i class="bi bi-arrow-up-circle-fill"></i> Nivel Óptimo
                                </p>
                            </div>
                        </div>

                        {{-- List Items --}}
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 hover:border-blue-200 hover:bg-blue-50/50 transition-all cursor-default group">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-lg bg-blue-100 text-upds-blue flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <i class="bi bi-compass"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-700">Alineación Estratégica</p>
                                        <p class="text-[10px] font-medium text-slate-400">Planificación 2026-2030</p>
                                    </div>
                                </div>
                                <i class="bi bi-chevron-right text-slate-300 text-xs"></i>
                            </div>

                            <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 hover:border-yellow-200 hover:bg-yellow-50/50 transition-all cursor-default group">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-lg bg-yellow-100 text-yellow-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <i class="bi bi-pie-chart"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-700">Inteligencia de Datos</p>
                                        <p class="text-[10px] font-medium text-slate-400">Análisis Predictivo</p>
                                    </div>
                                </div>
                                <i class="bi bi-chevron-right text-slate-300 text-xs"></i>
                            </div>

                            <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 hover:border-green-200 hover:bg-green-50/50 transition-all cursor-default group">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-lg bg-green-100 text-green-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <i class="bi bi-journal-text"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-700">Gestión Académica</p>
                                        <p class="text-[10px] font-medium text-slate-400">Control Docente</p>
                                    </div>
                                </div>
                                <i class="bi bi-chevron-right text-slate-300 text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- PILARES DE INNOVACIÓN --}}
    <section id="modelo" class="py-28 bg-slate-50 relative border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <h2 class="text-sm font-black text-upds-gold uppercase tracking-widest mb-3">Pilares de Innovación</h2>
                <h3 class="text-4xl lg:text-5xl font-black text-slate-900 mb-6">Transformando Datos en Decisiones</h3>
                <p class="text-lg text-slate-500">El Modelo AgileQ++ integra tecnologías de vanguardia con rigor académico para garantizar la calidad en cada proceso universitario.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Card 1 --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:border-upds-blue/20 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-upds-blue text-2xl mb-6 group-hover:scale-110 transition-transform">
                        <i class="bi bi-trophy-fill"></i>
                    </div>
                    <h4 class="text-lg font-bold text-slate-800 mb-3">Acreditación Continua</h4>
                    <p class="text-sm text-slate-500 leading-relaxed">Gestión sistemática de estándares para procesos de autoevaluación.</p>
                </div>

                {{-- Card 2 --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:border-upds-blue/20 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-yellow-50 rounded-2xl flex items-center justify-center text-yellow-600 text-2xl mb-6 group-hover:scale-110 transition-transform">
                        <i class="bi bi-bar-chart-steps"></i>
                    </div>
                    <h4 class="text-lg font-bold text-slate-800 mb-3">Indicadores 3G</h4>
                    <p class="text-sm text-slate-500 leading-relaxed">Métricas avanzadas que miden impacto y pertinencia institucional.</p>
                </div>

                {{-- Card 3 --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:border-upds-blue/20 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600 text-2xl mb-6 group-hover:scale-110 transition-transform">
                        <i class="bi bi-robot"></i>
                    </div>
                    <h4 class="text-lg font-bold text-slate-800 mb-3">IA Académica</h4>
                    <p class="text-sm text-slate-500 leading-relaxed">Algoritmos predictivos para la identificación temprana de riesgos.</p>
                </div>

                {{-- Card 4 --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:border-upds-blue/20 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 text-2xl mb-6 group-hover:scale-110 transition-transform">
                        <i class="bi bi-eye-fill"></i>
                    </div>
                    <h4 class="text-lg font-bold text-slate-800 mb-3">Transparencia Total</h4>
                    <p class="text-sm text-slate-500 leading-relaxed">Portal de datos abiertos para la rendición de cuentas institucional.</p>
                </div>

                 {{-- Card 5 --}}
                 <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:border-upds-blue/20 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600 text-2xl mb-6 group-hover:scale-110 transition-transform">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h4 class="text-lg font-bold text-slate-800 mb-3">Gestión de Talento</h4>
                    <p class="text-sm text-slate-500 leading-relaxed">Optimización del desempeño docente mediante perfiles por competencias.</p>
                </div>

                 {{-- Card 6 --}}
                 <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:border-upds-blue/20 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-cyan-50 rounded-2xl flex items-center justify-center text-cyan-600 text-2xl mb-6 group-hover:scale-110 transition-transform">
                        <i class="bi bi-lightning-charge-fill"></i>
                    </div>
                    <h4 class="text-lg font-bold text-slate-800 mb-3">Agilidad Operativa</h4>
                    <p class="text-sm text-slate-500 leading-relaxed">Reducción de burocracia mediante flujos de trabajo digitales.</p>
                </div>

                {{-- Stats Grandes --}}
                <div class="md:col-span-2 bg-upds-blue rounded-3xl p-10 flex flex-col justify-center relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -mr-16 -mt-16"></div>
                    
                    <div class="relative z-10 flex justify-around text-center">
                        <div>
                            <p class="text-5xl lg:text-6xl font-black text-upds-gold mb-2">98%</p>
                            <p class="text-blue-100 font-medium text-sm uppercase tracking-wider">Cumplimiento</p>
                        </div>
                        <div class="w-px bg-white/10"></div>
                        <div>
                            <p class="text-5xl lg:text-6xl font-black text-upds-gold mb-2">150+</p>
                            <p class="text-blue-100 font-medium text-sm uppercase tracking-wider">Indicadores</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- COMPROMISO INSTITUCIONAL --}}
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                
                {{-- Imagen Institucional (Unsplash) --}}
                <div class="relative h-[500px] rounded-3xl overflow-hidden shadow-2xl group">
                    <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=1000&auto=format&fit=crop" 
                         alt="Campus Universitario" 
                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-upds-blue/90 via-upds-blue/40 to-transparent"></div>
                    
                    <div class="absolute bottom-10 left-10 right-10">
                        <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-2xl">
                            <p class="text-white font-bold text-lg mb-2">"La calidad no es un acto, es un hábito."</p>
                            <p class="text-upds-gold text-sm font-bold uppercase tracking-widest">- Aristóteles</p>
                        </div>
                    </div>
                </div>

                {{-- Texto --}}
                <div>
                    <span class="text-upds-blue font-black text-xs uppercase tracking-[0.2em] mb-4 block">Compromiso Institucional</span>
                    <h2 class="text-4xl font-black text-slate-900 mb-6 leading-tight">Garantía de Calidad Respaldada por el Vicerrectorado</h2>
                    <p class="text-lg text-slate-600 mb-8 leading-relaxed">
                        La Universidad Privada Domingo Savio impulsa el Modelo AgileQ++ como el estándar dorado para la gestión universitaria moderna en la región.
                    </p>

                    <ul class="space-y-5">
                        <li class="flex items-start gap-4">
                            <div class="mt-1 w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0">
                                <i class="bi bi-check-lg text-sm font-bold"></i>
                            </div>
                            <span class="text-slate-700 font-medium">Evaluación por pares internacionales</span>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="mt-1 w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0">
                                <i class="bi bi-check-lg text-sm font-bold"></i>
                            </div>
                            <span class="text-slate-700 font-medium">Sincronización de datos en tiempo real</span>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="mt-1 w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0">
                                <i class="bi bi-check-lg text-sm font-bold"></i>
                            </div>
                            <span class="text-slate-700 font-medium">Protocolos de seguridad de nivel gubernamental</span>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="mt-1 w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0">
                                <i class="bi bi-check-lg text-sm font-bold"></i>
                            </div>
                            <span class="text-slate-700 font-medium">Soporte estratégico a decanatos</span>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-24 bg-upds-blue relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;"></div>
        
        <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
            <h2 class="text-3xl lg:text-5xl font-black text-white mb-6">¿Listo para elevar el estándar?</h2>
            <p class="text-xl text-blue-100 mb-10 max-w-2xl mx-auto">
                Solicite una demostración personalizada para su facultad y descubra el potencial de la toma de decisiones basada en datos.
            </p>
            <a href="#" class="inline-block bg-upds-gold text-upds-blue font-black text-lg px-10 py-5 rounded-2xl hover:bg-white transition-all shadow-xl hover:shadow-2xl hover:-translate-y-1">
                Solicitar Acceso Institucional
            </a>
        </div>
    </section>

    {{-- FOOTER COMPLETO --}}
    <footer class="bg-slate-900 text-slate-300 pt-20 pb-10 border-t border-slate-800 font-sans">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                
                {{-- Columna 1 --}}
                <div class="col-span-1 lg:col-span-1">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center text-upds-gold">
                            <i class="bi bi-mortarboard-fill text-xl"></i>
                        </div>
                        <div>
                            <span class="block text-white font-black text-xl">AgileQ++</span>
                            <span class="text-[10px] uppercase tracking-wider text-slate-500">Inteligencia Académica</span>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed text-slate-400 mb-6">
                        Plataforma de inteligencia académica para la gestión estratégica y acreditación de la calidad educativa.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:bg-upds-gold hover:text-upds-blue transition-colors"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:bg-upds-gold hover:text-upds-blue transition-colors"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:bg-upds-gold hover:text-upds-blue transition-colors"><i class="bi bi-twitter-x"></i></a>
                    </div>
                </div>

                {{-- Columna 2 --}}
                <div>
                    <h4 class="text-white font-bold mb-6 text-sm uppercase tracking-wider">Plataforma</h4>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li><a href="#" class="hover:text-upds-gold transition-colors">Panel de Indicadores</a></li>
                        <li><a href="#" class="hover:text-upds-gold transition-colors">Procesos de Acreditación</a></li>
                        <li><a href="#" class="hover:text-upds-gold transition-colors">Reportes de Gestión</a></li>
                        <li><a href="#" class="hover:text-upds-gold transition-colors">Seguimiento de Calidad</a></li>
                    </ul>
                </div>

                {{-- Columna 3 --}}
                <div>
                    <h4 class="text-white font-bold mb-6 text-sm uppercase tracking-wider">Soporte</h4>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li><a href="#" class="hover:text-upds-gold transition-colors">Manual de Usuario</a></li>
                        <li><a href="#" class="hover:text-upds-gold transition-colors">Capacitación Docente</a></li>
                        <li><a href="#" class="hover:text-upds-gold transition-colors">Mesa de Ayuda</a></li>
                        <li><a href="#" class="hover:text-upds-gold transition-colors">API & Integraciones</a></li>
                    </ul>
                </div>

                {{-- Columna 4 --}}
                <div>
                    <h4 class="text-white font-bold mb-6 text-sm uppercase tracking-wider">Contacto</h4>
                    <ul class="space-y-4 text-sm text-slate-400">
                        <li class="flex items-start gap-3">
                            <i class="bi bi-geo-alt-fill text-upds-gold mt-0.5"></i>
                            <span>Av. Beni y 3er Anillo Interno<br>Santa Cruz, Bolivia</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="bi bi-telephone-fill text-upds-gold"></i>
                            <span>+591 3 3421234</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="bi bi-envelope-fill text-upds-gold"></i>
                            <span>agileq@upds.edu.bo</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="bi bi-globe text-upds-gold"></i>
                            <span>www.upds.edu.bo</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs font-medium text-slate-500">
                <p>© 2026 Universidad Privada Domingo Savio. Todos los derechos reservados.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-white transition-colors">Privacidad</a>
                    <a href="#" class="hover:text-white transition-colors">Términos de Uso</a>
                    <a href="#" class="hover:text-white transition-colors">Seguridad</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>