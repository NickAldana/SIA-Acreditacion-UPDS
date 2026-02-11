@extends('layouts.app')

@section('title', 'Registrar Inversión - ' . $proyecto->CodigoProyecto)

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

        {{-- Encabezado de Navegación --}}
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('presupuesto.index', $proyecto->ProyectoinvestigacionID) }}" class="flex items-center text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-[#003566] transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Volver a la Billetera
            </a>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic">Nueva Entrada Financiera</span>
        </div>

        <div class="bg-white shadow-2xl rounded-2xl border border-slate-200 overflow-hidden">
            {{-- Banner Superior --}}
            <div class="bg-[#003566] p-8 text-white">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-white/10 rounded-xl backdrop-blur-md">
                        <i class="fas fa-hand-holding-dollar text-2xl text-[#FFC300]"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-black uppercase tracking-tighter">Registrar Movimiento</h2>
                        <p class="text-blue-200 text-[10px] font-bold uppercase tracking-widest mt-1">Expediente: {{ $proyecto->CodigoProyecto }}</p>
                    </div>
                </div>
            </div>

            {{-- Formulario --}}
            <form action="{{ route('presupuesto.store', $proyecto->ProyectoinvestigacionID) }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    {{-- 1. Monto y Fecha --}}
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest italic">Monto de la Inversión (Bs.)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">Bs.</span>
                                <input type="number" name="MontoAsignado" step="0.01" min="0.1" required
                                    class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-lg font-black text-[#003566] focus:ring-2 focus:ring-[#003566] focus:bg-white transition-all"
                                    placeholder="0.00">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest italic">Fecha de Ejecución/Asignación</label>
                            <input type="date" name="FechaAsignacion" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-[#003566]">
                        </div>
                    </div>

                    {{-- 2. Modalidad y Fondo --}}
                    <div class="space-y-6 text-slate-400">
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest italic">Modalidad de Fondo</label>
                            <select name="Modalidad" id="Modalidad" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-[#003566]">
                                <option value="Institucional">Institucional (Presupuesto U)</option>
                                <option value="Independiente">Independiente (Gasto Propio)</option>
                                <option value="Reembolsable">Reembolsable (Pendiente de Devolución)</option>
                            </select>
                        </div>

                        <div id="wrapper-fondo">
                            <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest italic">Fondo Específico</label>
                            <select name="FondoinversionID" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-[#003566]">
                                <option value="">-- Seleccionar Fondo IDH/U --</option>
                                @foreach($fondos as $fondo)
                                    <option value="{{ $fondo->FondoinversionID }}">
                                        {{ $fondo->NombreFondo }} ({{ $fondo->entidad->NombreEntidad }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- 3. Documento de Respaldo (Crítico para Acreditación) --}}
                <div class="p-6 bg-blue-50/50 border-2 border-dashed border-blue-200 rounded-2xl text-center">
                    <label class="cursor-pointer group">
                        <input type="file" name="archivo_respaldo" id="archivo_respaldo" class="hidden" accept=".pdf,.jpg,.jpeg,.png" required>
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-md mb-3 group-hover:scale-110 transition-transform">
                                <i class="fas fa-cloud-upload-alt text-blue-600"></i>
                            </div>
                            <p id="file-name" class="text-xs font-black text-blue-900 uppercase tracking-widest">Subir Comprobante / Factura</p>
                            <p class="text-[9px] text-blue-400 font-bold uppercase mt-1">PDF o Imagen (Máximo 10MB)</p>
                        </div>
                    </label>
                </div>

                {{-- 4. Observaciones --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest italic">Observación Adicional (Opcional)</label>
                    <textarea name="Observacion" rows="2" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-[#003566] placeholder:font-normal"
                        placeholder="Ej: Compra de materiales de oficina para trabajo de campo..."></textarea>
                </div>

                {{-- Botones de Acción --}}
                <div class="pt-6 border-t border-slate-100 flex justify-end gap-4">
                    <a href="{{ route('presupuesto.index', $proyecto->ProyectoinvestigacionID) }}" 
                       class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="px-10 py-4 bg-[#003566] text-white rounded-xl font-black text-xs uppercase tracking-[0.2em] shadow-xl hover:bg-slate-900 transition-all transform hover:-translate-y-1">
                        Consolidar Registro
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-8 p-6 bg-amber-50 border border-amber-200 rounded-xl">
            <div class="flex gap-4">
                <i class="fas fa-shield-halved text-amber-500 text-xl"></i>
                <p class="text-[10px] text-amber-800 font-medium leading-relaxed uppercase tracking-tight">
                    <strong class="block mb-1">Nota de Seguridad:</strong>
                    Toda inversión registrada será auditada para procesos de acreditación nacional. Asegúrese de que el monto coincida exactamente con el documento adjunto.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    // Dinamismo del Formulario
    const selectModalidad = document.getElementById('Modalidad');
    const wrapperFondo = document.getElementById('wrapper-fondo');
    const fileInput = document.getElementById('archivo_respaldo');
    const fileNameDisplay = document.getElementById('file-name');

    // 1. Mostrar/Ocultar Fondo según modalidad
    selectModalidad.addEventListener('change', function() {
        if(this.value === 'Institucional') {
            wrapperFondo.classList.remove('opacity-40', 'pointer-events-none');
            wrapperFondo.querySelector('select').required = true;
        } else {
            wrapperFondo.classList.add('opacity-40', 'pointer-events-none');
            wrapperFondo.querySelector('select').required = false;
        }
    });

    // 2. Mostrar nombre de archivo seleccionado
    fileInput.addEventListener('change', function() {
        if(this.files.length > 0) {
            fileNameDisplay.innerText = "Archivo: " + this.files[0].name;
            fileNameDisplay.classList.add('text-emerald-600');
        }
    });
</script>
@endsection