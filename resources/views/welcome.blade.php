@extends('layouts.app')

@section('content')
<style>
    /* Reset & Base */
    .sia-auth-bg {
        display: block !important;
        padding: 0 !important;
        background-color: #ffffff !important;
        overflow-y: auto !important;
    }

    :root {
        --upds-blue: #003566;
        --upds-gold: #ffc300;
        --text-main: #1e293b;
    }

    .bg-upds-blue { background-color: var(--upds-blue) !important; }
    .text-upds-blue { color: var(--upds-blue); }
    .text-upds-gold { color: var(--upds-gold); }

    .btn-upds-gold {
        background-color: var(--upds-gold);
        color: var(--upds-blue);
        font-weight: 800;
        letter-spacing: .05em;
        transition: all .2s ease;
        border: none;
    }

    .btn-upds-gold:hover {
        background-color: #e6b000;
        box-shadow: 0 4px 12px rgba(255,195,0,0.3);
        transform: translateY(-1px);
    }

    /* Mejora de tarjetas */
    .feature-card {
        transition: all 0.3s ease;
        border: 2px solid #f8fafc;
    }
    .feature-card:hover {
        border-color: var(--upds-gold);
        background-color: #ffffff;
        box-shadow: 0 10px 30px rgba(0, 53, 102, 0.05);
    }
</style>

<div class="flex flex-col min-h-screen font-sans">

    {{-- NAVBAR --}}
    <nav class="sticky top-0 z-50 bg-upds-blue shadow-lg">
        <div class="max-w-[1400px] mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <i class="bi bi-mortarboard-fill text-upds-gold fs-2"></i>
                <div class="border-l border-white/20 pl-4">
                    <span class="block font-black text-white text-xl leading-none">SIA</span>
                    <span class="text-[10px] font-bold text-white/60 uppercase tracking-widest">UPDS • Santa Cruz</span>
                </div>
            </div>

            <div class="flex items-center gap-8">
                <div class="hidden md:flex gap-8 font-bold uppercase text-xs tracking-wider">
                    <a href="#modelo" class="text-white hover:text-upds-gold no-underline transition">Modelo</a>
                    <a href="#contacto" class="text-white hover:text-upds-gold no-underline transition">Institucional</a>
                </div>
                <a href="{{ route('login') }}" class="btn-upds-gold px-6 py-2 rounded-lg text-xs no-underline uppercase shadow-sm">
                    Acceso al Sistema
                </a>
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <header class="relative bg-slate-50 py-16 lg:py-28 overflow-hidden border-b">
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center">
            
            <div>
                <div class="inline-block px-4 py-1 mb-6 rounded-md bg-upds-blue text-upds-gold text-[10px] font-bold uppercase tracking-widest shadow-sm">
                    Vicerrectorado Académico
                </div>
                
                <h1 class="font-black text-upds-blue leading-tight text-5xl md:text-7xl mb-6">
                    Modelo <br><span class="text-upds-gold">AgileQ++</span>
                </h1>

                <p class="text-xl text-gray-700 font-bold mb-4 leading-snug">
                    Gestión estratégica de indicadores para procesos de <span class="text-upds-blue border-b-4 border-upds-gold">acreditación y calidad educativa</span>.
                </p>

                <p class="text-gray-600 text-lg mb-10 max-w-xl leading-relaxed">
                    Plataforma diseñada para la integración y visualización de datos académicos, facilitando la toma de decisiones basada en evidencia.
                </p>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('login') }}" class="btn-upds-gold px-10 py-4 rounded-xl text-sm no-underline flex items-center gap-3 shadow-lg hover:shadow-xl transition-all">
                        EXPLORAR PLATAFORMA <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            {{-- TARJETA DE CAPACIDADES --}}
            <div class="hidden lg:flex justify-end">
                <div class="bg-white p-8 rounded-3xl shadow-2xl border border-gray-100 relative overflow-hidden max-w-sm">
                    <div class="absolute -top-10 -right-10 bg-upds-blue/5 w-40 h-40 rounded-full"></div>
                    
                    <div class="relative">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="bg-upds-gold text-upds-blue text-[9px] px-2 py-0.5 rounded font-black tracking-tighter">DESARROLLO SISTEMA</span>
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">SIA v4.0</span>
                        </div>
                        
                        <h3 class="font-black text-upds-blue text-2xl mb-1">Panel de Control</h3>
                        <p class="text-xs text-blue-600 font-bold uppercase tracking-tight mb-4">Análisis de Datos UPDS</p>
                        
                        <hr class="border-gray-100 my-4">
                        
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <div class="mt-1 bg-green-100 rounded-full p-1 shrink-0">
                                    <i class="bi bi-check2 text-green-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800 mb-0 leading-none">Alineación Estratégica</p>
                                    <p class="text-[11px] text-gray-500 mt-1">Soporte a procesos de autoevaluación interna.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="mt-1 bg-blue-100 rounded-full p-1 shrink-0">
                                    <i class="bi bi-bar-chart-fill text-blue-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800 mb-0 leading-none">Inteligencia de Datos</p>
                                    <p class="text-[11px] text-gray-500 mt-1">Métricas de 3ra generación y visualización BI.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="mt-1 bg-purple-100 rounded-full p-1 shrink-0">
                                    <i class="bi bi-database-fill-gear text-purple-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800 mb-0 leading-none">Gestión Académica</p>
                                    <p class="text-[11px] text-gray-500 mt-1">Integración modular con registros institucionales.</p>
                                </div>
                            </li>
                        </ul>

                        <div class="mt-6 p-3 bg-slate-50 rounded-xl border border-dashed border-gray-200">
                            <p class="text-[10px] text-gray-400 font-bold italic text-center uppercase tracking-tighter mb-0">
                                "Transformando datos en excelencia académica"
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- PILARES --}}
    <section id="modelo" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="font-black text-upds-blue text-3xl uppercase tracking-tight mb-2">Pilares del Sistema</h2>
                <div class="w-20 h-1.5 bg-upds-gold mx-auto rounded-full"></div>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="feature-card p-8 rounded-2xl bg-slate-50">
                    <i class="bi bi-lightning-charge-fill text-upds-blue fs-1 mb-4 block"></i>
                    <h4 class="font-black text-upds-blue text-xl mb-3">Gestión Ágil</h4>
                    <p class="text-gray-600 font-medium text-sm leading-relaxed">Optimización de procesos académicos y administrativos orientados al talento humano de la sede.</p>
                </div>

                <div class="p-8 rounded-2xl bg-upds-blue text-white shadow-xl transform md:-translate-y-2">
                    <i class="bi bi-graph-up text-upds-gold fs-1 mb-4 block"></i>
                    <h4 class="font-black text-xl mb-3">Indicadores 3G</h4>
                    <p class="text-blue-100 font-medium text-sm leading-relaxed">Métricas avanzadas para el seguimiento de formación, investigación y pertinencia institucional.</p>
                </div>

                <div class="feature-card p-8 rounded-2xl bg-slate-50">
                    <i class="bi bi-shield-check text-upds-blue fs-1 mb-4 block"></i>
                    <h4 class="font-black text-upds-blue text-xl mb-3">Calidad Educativa</h4>
                    <p class="text-gray-600 font-medium text-sm leading-relaxed">Soporte técnico para el cumplimiento de estándares institucionales de calidad y mejora continua.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer id="contacto" class="bg-upds-blue text-white pt-16 pb-8 mt-auto">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-3 gap-12 border-b border-white/10 pb-12">
                
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <i class="bi bi-mortarboard-fill text-upds-gold fs-2"></i>
                        <span class="font-black text-2xl tracking-tighter">SIA UPDS</span>
                    </div>
                    <p class="text-blue-100 font-medium text-sm leading-relaxed">
                        Sistema Integrado de Acreditación. Herramienta estratégica para el aseguramiento de la calidad en la UPDS Santa Cruz.
                    </p>
                </div>

                <div>
                    <h5 class="text-upds-gold font-black text-xs tracking-[.2em] mb-6 uppercase">Ubicación y Sede</h5>
                    <p class="text-white mb-1 font-bold text-sm">Av. Beni y 3er Anillo Interno</p>
                    <p class="text-blue-200 text-sm">Santa Cruz de la Sierra, Bolivia</p>
                </div>

                <div class="md:text-right">
                    <h5 class="text-upds-gold font-black text-xs tracking-[.2em] mb-6 uppercase">SIA v4.0</h5>
                    <p class="text-blue-100 font-bold text-sm">Vicerrectorado Académico</p>
                    <div class="flex md:justify-end gap-4 mt-4 text-xl text-white/80">
                        <i class="bi bi-facebook cursor-pointer hover:text-upds-gold transition"></i>
                        <i class="bi bi-globe cursor-pointer hover:text-upds-gold transition"></i>
                        <i class="bi bi-linkedin cursor-pointer hover:text-upds-gold transition"></i>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-[10px] font-bold text-blue-300 uppercase tracking-widest">
                    © {{ date('Y') }} Universidad Privada Domingo Savio
                </p>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    <p class="text-[10px] text-blue-400 font-bold uppercase mb-0">
                        SIA Intelligence System v4.0
                    </p>
                </div>
            </div>
        </div>
    </footer>

</div>
@endsection