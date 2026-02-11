@extends('layouts.app')

@section('title', 'Presupuesto: ' . $proyecto->CodigoProyecto)

@section('content')
<div class="py-10 bg-slate-100 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Encabezado de Navegación --}}
        <div class="flex justify-between items-center no-print">
            <a href="{{ route('investigacion.show', $proyecto->ProyectoinvestigacionID) }}" class="flex items-center text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-[#003566] transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Volver al Proyecto
            </a>
            <div class="flex gap-3">
                <a href="{{ route('presupuesto.reporte_pdf', $proyecto->ProyectoinvestigacionID) }}" class="px-4 py-2 bg-rose-700 text-white rounded shadow text-[10px] font-black uppercase tracking-widest hover:bg-rose-800 transition-all flex items-center">
                    <i class="fas fa-file-pdf mr-2"></i> Reporte Financiero
                </a>
                <a href="{{ route('presupuesto.create', $proyecto->ProyectoinvestigacionID) }}" class="px-4 py-2 bg-[#FFC300] text-[#003566] rounded shadow text-[10px] font-black uppercase tracking-widest hover:bg-yellow-400 transition-all flex items-center">
                    <i class="fas fa-plus-circle mr-2"></i> Registrar Inversión
                </a>
            </div>
        </div>

        {{-- 1. TARJETAS DE MÉTRICAS (Dashboard) --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Total Ejecutado --}}
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Invertido</p>
                <h3 class="text-2xl font-black text-[#003566] tracking-tighter">
                    Bs. {{ number_format($totales['asignado'], 2) }}
                </h3>
                <div class="mt-2 h-1 w-full bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-500" style="width: 100%"></div>
                </div>
            </div>

            {{-- Acreditable (Verde) --}}
            <div class="bg-emerald-50 p-5 rounded-xl border border-emerald-100 shadow-sm">
                <p class="text-[9px] font-black text-emerald-600 uppercase tracking-widest mb-1">Monto Acreditable</p>
                <h3 class="text-2xl font-black text-emerald-700 tracking-tighter">
                    Bs. {{ number_format($totales['acreditable'], 2) }}
                </h3>
                <p class="text-[8px] font-bold text-emerald-500 mt-1 uppercase italic">Validado para auditoría</p>
            </div>

            {{-- Institucional (U) --}}
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Fondos Institucionales</p>
                <h3 class="text-2xl font-black text-slate-700 tracking-tighter">
                    Bs. {{ number_format($totales['institucional'], 2) }}
                </h3>
                <p class="text-[8px] font-bold text-slate-400 mt-1 uppercase">Proveniente de la Universidad</p>
            </div>

            {{-- Aporte Propio (Docentes) --}}
            <div class="bg-amber-50 p-5 rounded-xl border border-amber-100 shadow-sm">
                <p class="text-[9px] font-black text-amber-600 uppercase tracking-widest mb-1">Aporte Propio</p>
                <h3 class="text-2xl font-black text-amber-700 tracking-tighter">
                    Bs. {{ number_format($totales['propio'], 2) }}
                </h3>
                <p class="text-[8px] font-bold text-amber-500 mt-1 uppercase">Independiente / Reembolsable</p>
            </div>
        </div>

        {{-- 2. LISTADO DE MOVIMIENTOS --}}
        <div class="bg-white border border-slate-300 shadow-xl overflow-hidden rounded-lg">
            <div class="bg-slate-800 px-6 py-4 flex justify-between items-center border-b border-slate-700">
                <h3 class="text-white text-xs font-black uppercase tracking-[0.2em]">Historial de Movimientos Financieros</h3>
                <span class="text-slate-400 text-[9px] font-mono uppercase">Expediente: {{ $proyecto->CodigoProyecto }}</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 border-b border-slate-200">
                            <th class="px-6 py-4 text-[9px] font-black uppercase tracking-widest">Fecha</th>
                            <th class="px-6 py-4 text-[9px] font-black uppercase tracking-widest">Fuente / Fondo</th>
                            <th class="px-6 py-4 text-[9px] font-black uppercase tracking-widest">Modalidad</th>
                            <th class="px-6 py-4 text-[9px] font-black uppercase tracking-widest">Monto</th>
                            <th class="px-6 py-4 text-[9px] font-black uppercase tracking-widest text-center">Respaldo</th>
                            <th class="px-6 py-4 text-[9px] font-black uppercase tracking-widest text-center">Acred.</th>
                            <th class="px-6 py-4 text-[9px] font-black uppercase tracking-widest text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($movimientos as $mov)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4 text-[10px] font-bold text-slate-500 font-mono">
                                {{ $mov->FechaAsignacion->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-[10px] font-black text-slate-700 uppercase leading-tight">
                                    {{ $mov->fondo->NombreFondo ?? 'APORTE EXTERNO' }}
                                </p>
                                <p class="text-[8px] text-slate-400 font-bold uppercase tracking-tighter">
                                    {{ $mov->fondo->entidad->NombreEntidad ?? 'INDEPENDIENTE' }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-[8px] font-black px-2 py-1 rounded bg-slate-100 text-slate-600 uppercase border border-slate-200">
                                    {{ $mov->Modalidad }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-black text-[#003566] tracking-tighter">Bs. {{ number_format($mov->MontoAsignado, 2) }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($mov->RutaRespaldoAsignacion)
                                    <a href="{{ asset('storage/' . $mov->RutaRespaldoAsignacion) }}" target="_blank" class="text-blue-600 hover:text-blue-800 transition-transform hover:scale-110 inline-block">
                                        <i class="fas fa-file-invoice text-lg"></i>
                                    </a>
                                @else
                                    <span class="text-rose-300"><i class="fas fa-times-circle"></i></span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('presupuesto.toggle', [$proyecto->ProyectoinvestigacionID, $mov->PresupuestoID]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="transition-colors {{ $mov->ValidacionAcreditacion ? 'text-emerald-500 hover:text-emerald-700' : 'text-slate-300 hover:text-rose-500' }}">
                                        <i class="fas {{ $mov->ValidacionAcreditacion ? 'fa-check-circle' : 'fa-circle' }} text-lg"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    {{-- Botón para ver observación si existe --}}
                                    @if($mov->Observacion)
                                        <button onclick="alert('{{ $mov->Observacion }}')" class="text-slate-400 hover:text-slate-600"><i class="fas fa-comment-dots"></i></button>
                                    @endif
                                    
                                    <form action="{{ route('presupuesto.destroy', [$proyecto->ProyectoinvestigacionID, $mov->PresupuestoID]) }}" method="POST" onsubmit="return confirm('¿Eliminar este registro financiero?')">
                                        @csrf @method('DELETE')
                                        <button class="text-rose-400 hover:text-rose-600"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-20 text-center text-slate-400">
                                <i class="fas fa-wallet text-4xl mb-3 opacity-20"></i>
                                <p class="text-xs font-black uppercase tracking-[0.3em]">Sin movimientos registrados</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pie de Sistema --}}
        <div class="text-center py-4">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.5em]">Auditoría Financiera SIA v4.0</p>
        </div>
    </div>
</div>
@endsection