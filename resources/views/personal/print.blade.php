<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kardex_{{ $docente->Ci }}_{{ Str::slug($docente->Apellidopaterno) }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        /* ESTILOS DE IMPRESIÓN OFICIALES UPDS V4.1 */
        :root {
            --upds-blue: #003566;
            --upds-gold: #ffc300;
            --text-dark: #111827;
        }
        body { font-family: 'Segoe UI', Arial, sans-serif; font-size: 11px; color: var(--text-dark); background-color: #525659; }
        
        .page-sheet { background-color: white; width: 210mm; min-height: 297mm; margin: 30px auto; padding: 15mm; box-shadow: 0 0 15px rgba(0,0,0,0.3); position: relative; }
        
        /* Encabezado */
        .doc-header { border-bottom: 2px solid var(--upds-blue); padding-bottom: 15px; margin-bottom: 25px; }
        .logo-text { color: var(--upds-blue); font-weight: 900; font-size: 28px; line-height: 1; }
        
        /* Títulos de Sección */
        .section-header { 
            background-color: var(--upds-blue); 
            color: white; 
            padding: 6px 10px; 
            font-weight: 700; 
            text-transform: uppercase; 
            font-size: 11px; 
            margin-top: 25px; 
            margin-bottom: 10px; 
            border-left: 5px solid var(--upds-gold); 
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Tablas */
        .table-custom { width: 100%; border-collapse: collapse; font-size: 10px; margin-bottom: 10px; }
        .table-custom th { 
            background-color: #f3f4f6; 
            border: 1px solid #d1d5db; 
            padding: 6px; 
            font-weight: 700; 
            text-transform: uppercase; 
            color: var(--upds-blue); 
            text-align: left;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .table-custom td { border: 1px solid #e5e7eb; padding: 6px; vertical-align: middle; }
        
        /* Datos */
        .data-label { font-weight: 700; color: #6b7280; text-transform: uppercase; font-size: 9px; margin-bottom: 2px; }
        .data-value { font-weight: 600; color: #000; border-bottom: 1px dotted #ccc; padding-bottom: 2px; font-size: 11px; }
        
        /* Marca de Agua */
        .watermark { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); opacity: 0.04; font-size: 150px; font-weight: 900; color: var(--upds-blue); z-index: 0; pointer-events: none; }
        
        /* Botones Flotantes (No se imprimen) */
        .floating-actions { position: fixed; top: 20px; right: 20px; z-index: 1000; display: flex; gap: 10px; }
        
        @media print {
            body { background-color: white; margin: 0; }
            .page-sheet { box-shadow: none; margin: 0; width: 100%; padding: 0; }
            .no-print, .floating-actions { display: none !important; }
            @page { margin: 1.5cm; size: auto; }
            .section-header { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>

    <div class="floating-actions no-print">
        <button onclick="window.print()" class="btn btn-primary fw-bold shadow-sm rounded-pill px-4"><i class="bi bi-printer-fill me-2"></i> Imprimir</button>
        <button onclick="window.close()" class="btn btn-light fw-bold shadow-sm rounded-pill px-4"><i class="bi bi-x-lg me-2"></i> Cerrar</button>
    </div>

    <div class="page-sheet">
        <div class="watermark">UPDS</div>

        {{-- 1. ENCABEZADO --}}
        <div class="doc-header d-flex justify-content-between align-items-end position-relative" style="z-index: 1;">
            <div>
                <div class="logo-text">UPDS</div>
                <div class="text-uppercase fw-bold text-muted small" style="letter-spacing: 2px; font-size: 9px;">Universidad Privada Domingo Savio</div>
                <div class="text-muted" style="font-size: 9px;">Gestión Académica</div>
            </div>
            <div class="text-end">
                <h4 class="fw-bold m-0 text-uppercase text-upds-blue">Kardex Académico</h4>
                <div class="small fw-bold mt-1 text-primary">ID: P-{{ str_pad($docente->PersonalID, 5, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>

        <div class="text-end mb-3" style="font-size: 9px; color: #666;">
            Fecha de Emisión: {{ date('d/m/Y H:i') }} | Usuario: {{ Auth::user()->NombreUsuario ?? 'Sistema' }}
        </div>

        {{-- 2. DATOS PERSONALES --}}
        <div class="section-header">I. Datos de Identificación y Vinculación</div>
        
        <div class="row g-3 mb-3 position-relative" style="z-index: 1;">
            <div class="col-2 text-center">
                @if($docente->Fotoperfil)
                    <img src="{{ asset('storage/'.$docente->Fotoperfil) }}" style="width: 80px; height: 100px; object-fit: cover; border: 1px solid #ddd; padding: 2px; border-radius: 4px;">
                @else
                    <div style="width: 80px; height: 100px; border: 1px dashed #ccc; display: flex; align-items: center; justify-content: center; background: #f9f9f9; margin: 0 auto; border-radius: 4px;">
                        <span style="font-size: 9px; color: #999; text-align: center;">FOTO<br>PENDIENTE</span>
                    </div>
                @endif
                <div class="mt-1">
                    <span class="badge {{ $docente->Activo ? 'bg-success' : 'bg-secondary' }} border border-white" style="font-size: 8px;">
                        {{ $docente->Activo ? 'ACTIVO' : 'INACTIVO' }}
                    </span>
                </div>
            </div>

            <div class="col-10">
                <div class="row g-2">
                    <div class="col-8">
                        <div class="data-label">Nombre Completo</div>
                        <div class="data-value text-uppercase">
                            {{ $docente->Apellidopaterno }} {{ $docente->Apellidomaterno }}, {{ $docente->Nombrecompleto }}
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="data-label">Cédula de Identidad</div>
                        <div class="data-value fw-bold">{{ $docente->Ci }}</div>
                    </div>

                    <div class="col-6">
                        <div class="data-label">Cargo Institucional</div>
                        <div class="data-value">{{ $docente->cargo->Nombrecargo ?? 'SIN ASIGNACIÓN' }}</div>
                    </div>
                    <div class="col-6">
                        <div class="data-label">Modalidad de Contrato</div>
                        <div class="data-value">{{ $docente->contrato->Nombrecontrato ?? 'SIN CONTRATO' }}</div>
                    </div>

                    <div class="col-6">
                        <div class="data-label">Correo Electrónico</div>
                        <div class="data-value text-lowercase">{{ $docente->Correoelectronico }}</div>
                    </div>
                    <div class="col-3">
                        <div class="data-label">Teléfono</div>
                        <div class="data-value">{{ $docente->Telelefono ?? '-' }}</div>
                    </div>
                    <div class="col-3">
                        <div class="data-label">Antigüedad/Exp.</div>
                        <div class="data-value">{{ $docente->Añosexperiencia ?? '0' }} Años</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. FORMACIÓN ACADÉMICA --}}
        <div class="section-header">II. Formación Académica Registrada</div>
        <table class="table-custom">
            <thead>
                <tr>
                    <th style="width: 20%">Nivel</th>
                    <th style="width: 50%">Profesión / Título Obtenido</th>
                    <th style="width: 30%">Institución</th>
                </tr>
            </thead>
            <tbody>
                @forelse($docente->formaciones as $f)
                <tr>
                    <td>{{ $f->grado->Nombregrado ?? '-' }}</td>
                    <td>
                        {{-- Ajuste: Mostrar Profesión en Negrita y Título abajo --}}
                        <div class="fw-bold text-uppercase">{{ $f->NombreProfesion }}</div>
                        @if($f->Tituloobtenido != $f->NombreProfesion)
                            <div class="text-muted" style="font-size: 9px;">{{ $f->Tituloobtenido }}</div>
                        @endif
                    </td>
                    <td>{{ $f->centro->Nombrecentro ?? 'Institución Externa' }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center py-2 text-muted">- No registra formación académica -</td></tr>
                @endforelse
            </tbody>
        </table>

        {{-- 4. CARGA ACADÉMICA --}}
        <div class="section-header">III. Carga Académica (Gestión {{ date('Y') }})</div>
        <table class="table-custom">
            <thead>
                <tr>
                    <th style="width: 10%" class="text-center">Periodo</th>
                    <th style="width: 15%" class="text-center">Sigla</th>
                    <th style="width: 55%">Asignatura</th>
                    <th style="width: 10%" class="text-center">Grupo</th>
                    <th style="width: 10%" class="text-center">Modalidad</th>
                </tr>
            </thead>
            <tbody>
                @forelse($docente->materias as $m)
                <tr>
                    {{-- CORRECCIÓN: Usar 'carga' en lugar de 'pivot' --}}
                    <td class="text-center fw-bold">{{ $m->carga->Gestion }}-{{ $m->carga->Periodo }}</td>
                    <td class="text-center">{{ $m->Sigla ?? '-' }}</td>
                    <td>{{ $m->Nombremateria }}</td>
                    <td class="text-center fw-bold">{{ $m->carga->Grupo }}</td>
                    <td class="text-center" style="font-size: 9px;">{{ $m->carga->Modalidad }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-2 text-muted">- Sin carga asignada esta gestión -</td></tr>
                @endforelse
            </tbody>
        </table>

        {{-- 5. ÁREAS DE VINCULACIÓN --}}
        <div class="section-header">IV. Áreas de Vinculación</div>
        <div class="border p-2" style="background-color: #fcfcfc; border: 1px solid #e5e7eb;">
            @php
                // Lógica corregida para N:M (usando flatMap porque subjects tiene muchas carreras)
                $carrerasUnicas = $docente->materias->flatMap(function ($materia) {
                    return $materia->carreras;
                })->unique('CarreraID');
            @endphp

            @if($carrerasUnicas->isNotEmpty())
                <table style="width: 100%; font-size: 10px;">
                    <tr>
                    @foreach($carrerasUnicas as $index => $carrera)
                        <td style="width: 50%; padding: 2px;">
                            <span style="color: #003566;">&#10003;</span> {{ $carrera->Nombrecarrera }}
                        </td>
                        {{-- Romper fila cada 2 elementos --}}
                        @if(($index + 1) % 2 == 0) </tr><tr> @endif
                    @endforeach
                    </tr>
                </table>
            @else
                <div class="text-muted text-center fst-italic" style="font-size: 10px;">Sin vinculación específica a carreras actualmente.</div>
            @endif
        </div>

        {{-- 6. PRODUCCIÓN INTELECTUAL --}}
        <div class="section-header">V. Producción Intelectual</div>
        <table class="table-custom">
            <thead>
                <tr>
                    <th style="width: 15%" class="text-center">Fecha</th>
                    <th style="width: 20%">Tipo</th>
                    <th style="width: 65%">Título de la Obra</th>
                </tr>
            </thead>
            <tbody>
                @forelse($docente->publicaciones as $pub)
                <tr>
                    <td class="text-center">{{ \Carbon\Carbon::parse($pub->Fechapublicacion)->format('d/m/Y') }}</td>
                    <td class="text-uppercase" style="font-size: 9px;">{{ $pub->tipo->Nombretipo ?? '-' }}</td>
                    <td>"{{ $pub->Nombrepublicacion }}" <span class="text-muted" style="font-size: 9px;">({{ $pub->medio->Nombremedio ?? '' }})</span></td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center py-2 text-muted">- Sin producción registrada -</td></tr>
                @endforelse
            </tbody>
        </table>

        {{-- PIE DE PÁGINA (Firmas) --}}
        <div class="row" style="margin-top: 60px;">
            <div class="col-4 text-center">
                <div style="border-top: 1px solid #333; width: 90%; margin: 0 auto; padding-top: 5px;">
                    <div class="fw-bold text-uppercase" style="font-size: 9px;">{{ $docente->Apellidopaterno }} {{ $docente->Apellidomaterno }}</div>
                    <div style="font-size: 9px;">Firma del Docente</div>
                </div>
            </div>
            <div class="col-4 text-center"></div>
            <div class="col-4 text-center">
                <div style="border-top: 1px solid #333; width: 90%; margin: 0 auto; padding-top: 5px;">
                    <div class="fw-bold text-uppercase" style="font-size: 9px;">Talento Humano</div>
                    <div style="font-size: 9px;">Sello y Firma Autorizada</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>