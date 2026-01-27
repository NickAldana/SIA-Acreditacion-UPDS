@extends('layouts.app')

@section('content')
<style>
    /* Reset de márgenes para que el Welcome sea de ancho completo */
    .sia-auth-bg { 
        display: block !important; 
        padding: 0 !important; 
        background-color: white !important; 
        overflow-y: auto !important;
    }
    
    /* Variables de color consistentes con el Dashboard */
    :root {
        --upds-blue: #003566;
        --upds-gold: #ffc300;
    }

    .bg-upds-blue { background-color: var(--upds-blue) !important; }
    .text-upds-gold { color: var(--upds-gold) !important; }
    .btn-upds-gold { 
        background-color: var(--upds-gold); 
        color: var(--upds-blue); 
        font-weight: 900;
        transition: all 0.3s;
    }
    .btn-upds-gold:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 8px 20px rgba(255, 195, 0, 0.4);
        background-color: #e6b000;
    }
</style>

<div class="flex flex-col min-h-screen">
    
    <nav class="sticky top-0 z-50 bg-upds-blue shadow-xl py-3 px-8 lg:px-12 flex justify-between items-center border-b border-white/10">
        <div class="flex items-center gap-3">
            <i class="bi bi-mortarboard-fill text-upds-gold fs-2"></i>
            <div>
                <span class="block font-black text-white text-xl tracking-tighter leading-none">SIA</span>
                <span class="text-[9px] font-bold text-blue-200/60 uppercase tracking-[0.2em]">UPDS Santa Cruz</span>
            </div>
        </div>

        <div class="flex items-center gap-6">
            {{-- Enlaces en blanco para fondo azul --}}
            <div class="hidden md:flex gap-6 mr-4">
                <a href="#servicios" class="text-[10px] font-black text-white/70 hover:text-upds-gold uppercase tracking-widest transition">Servicios</a>
                <a href="#contacto" class="text-[10px] font-black text-white/70 hover:text-upds-gold uppercase tracking-widest transition">Contacto</a>
            </div>
            
            <a href="{{ route('login') }}" class="btn-upds-gold px-6 py-2 rounded-full text-[11px] uppercase tracking-wider shadow-lg border-0">
                Acceso Sistema
            </a>
        </div>
    </nav>

    <header class="relative bg-slate-50 overflow-hidden flex items-center" style="min-height: 75vh;">
        {{-- Patrón de fondo sutil --}}
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>

        <div class="container mx-auto px-6 lg:px-12 grid lg:grid-cols-2 gap-12 items-center relative z-10">
            <div class="animate__animated animate__fadeInLeft">
                <div class="inline-flex items-center gap-2 py-1 px-3 rounded-full bg-blue-50 border border-blue-100 mb-6">
                    <span class="sia-ui-pulse"></span>
                    <span class="text-[10px] font-black text-upds-blue uppercase tracking-widest">Vicerrectorado Académico</span>
                </div>

                <h1 class="text-6xl lg:text-8xl font-black text-upds-blue tracking-tighter leading-[0.85] mb-8">
                    Gestión <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#003566] to-[#00509d]">Académica</span><br>
                    SIA V4.0
                </h1>
                
                <p class="text-gray-500 text-lg mb-10 max-w-lg leading-relaxed font-medium">
                    Plataforma estratégica para la administración de personal, acreditación y seguimiento de carga horaria en la Universidad Privada Domingo Savio.
                </p>
                
                <div class="flex gap-4">
                    <a href="{{ route('login') }}" class="btn-upds-gold px-10 py-4 rounded-2xl text-sm flex items-center gap-3 shadow-2xl">
                        COMENZAR AHORA <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>

            <div class="hidden lg:flex justify-center items-center animate__animated animate__fadeInRight">
                {{-- Icono representativo del sistema --}}
                <div class="relative">
                    <i class="bi bi-mortarboard text-upds-blue opacity-5" style="font-size: 28rem;"></i>
                    <div class="absolute inset-0 flex items-center justify-center">
                         <div class="bg-white p-8 rounded-[3rem] shadow-2xl border border-gray-100 rotate-3">
                             <i class="bi bi-shield-check text-upds-blue" style="font-size: 5rem;"></i>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section id="servicios" class="py-24 bg-white container mx-auto px-6 lg:px-12">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-4">
            <div>
                <h2 class="text-4xl font-black text-upds-blue tracking-tighter">Módulos Integrados</h2>
                <p class="text-gray-400 font-bold uppercase text-[10px] tracking-[0.3em] mt-2">Arquitectura Modular V4.0</p>
            </div>
            <div class="h-px bg-gray-100 flex-grow mx-8 hidden md:block"></div>
        </div>
        
        <div class="grid md:grid-cols-3 gap-10">
            <div class="group">
                <div class="mb-6 inline-block p-4 bg-slate-50 rounded-2xl text-upds-blue group-hover:bg-upds-blue group-hover:text-white transition-all duration-300">
                    <i class="bi bi-people-fill fs-3"></i>
                </div>
                <h4 class="font-black text-upds-blue text-xl mb-3">Directorio Docente</h4>
                <p class="text-sm text-gray-500 leading-relaxed">Gestión de expedientes y formación académica para el aseguramiento de la calidad educativa.</p>
            </div>

            <div class="group">
                <div class="mb-6 inline-block p-4 bg-slate-50 rounded-2xl text-upds-blue group-hover:bg-upds-blue group-hover:text-white transition-all duration-300">
                    <i class="bi bi-calendar-check-fill fs-3"></i>
                </div>
                <h4 class="font-black text-upds-blue text-xl mb-3">Carga Académica</h4>
                <p class="text-sm text-gray-500 leading-relaxed">Asignación eficiente de materias y seguimiento de cumplimiento de compromisos docentes.</p>
            </div>

            <div class="group">
                <div class="mb-6 inline-block p-4 bg-slate-50 rounded-2xl text-upds-blue group-hover:bg-upds-blue group-hover:text-white transition-all duration-300">
                    <i class="bi bi-graph-up-arrow fs-3"></i>
                </div>
                <h4 class="font-black text-upds-blue text-xl mb-3">Reportes BI</h4>
                <p class="text-sm text-gray-500 leading-relaxed">Visualización de indicadores clave de acreditación mediante integración nativa con Power BI.</p>
            </div>
        </div>
    </section>

    <footer id="contacto" class="bg-upds-blue text-white py-20 mt-auto">
        <div class="container mx-auto px-6 lg:px-12 grid md:grid-cols-3 gap-16">
            <div class="flex flex-col gap-6">
                <div class="flex items-center gap-3">
                    <i class="bi bi-mortarboard-fill text-upds-gold fs-2"></i>
                    <span class="font-black text-2xl tracking-tighter">SIA UPDS</span>
                </div>
                <p class="text-sm text-blue-200/50 leading-relaxed font-medium">
                    Sistema oficial de gestión académica de la Universidad Privada Domingo Savio, sede Santa Cruz. Desarrollado para el Vicerrectorado Académico.
                </p>
            </div>
            
            <div>
                <h5 class="text-upds-gold font-black uppercase text-[10px] tracking-[0.3em] mb-8">Información</h5>
                <ul class="space-y-4 text-sm font-medium text-blue-100/70">
                    <li class="flex items-center gap-3"><i class="bi bi-geo-alt-fill text-upds-gold"></i> Av. Beni y 3er Anillo Interno</li>
                    <li class="flex items-center gap-3"><i class="bi bi-envelope-fill text-upds-gold"></i> soporte.sia@upds.edu.bo</li>
                </ul>
            </div>

            <div>
                <h5 class="text-upds-gold font-black uppercase text-[10px] tracking-[0.3em] mb-8">Seguridad</h5>
                <p class="text-xs text-blue-100/40 leading-relaxed">
                    El acceso a esta plataforma está monitoreado. Se requiere autenticación válida para consultar datos sensibles de la institución.
                </p>
            </div>
        </div>
        <div class="container mx-auto px-6 lg:px-12 mt-20 pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[10px] text-blue-200/30 font-bold uppercase tracking-[0.4em]">© {{ date('Y') }} Universidad Privada Domingo Savio</p>
            <div class="flex gap-4 opacity-30">
                <i class="bi bi-facebook"></i>
                <i class="bi bi-instagram"></i>
                <i class="bi bi-linkedin"></i>
            </div>
        </div>
    </footer>
</div>
@endsection