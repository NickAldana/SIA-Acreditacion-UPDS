<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Financiero - {{ $proyecto->CodigoProyecto }}</title>
    <style>
        @page { margin: 2cm; }
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.4; font-size: 11px; }
        
        /* Encabezado Institucional */
        .header { width: 100%; border-bottom: 2px solid #003566; padding-bottom: 10px; margin-bottom: 20px; }
        .header td { vertical-align: middle; }
        .u-name { font-size: 16px; font-weight: bold; color: #003566; text-transform: uppercase; }
        .doc-title { font-size: 12px; font-weight: bold; color: #666; text-align: right; text-transform: uppercase; }

        /* Información del Proyecto */
        .project-box { background-color: #f8fafc; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #e2e8f0; }
        .project-title { font-size: 13px; font-weight: bold; color: #003566; text-transform: uppercase; margin-bottom: 5px; }
        
        /* Resumen Financiero */
        .summary-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .summary-table th { background-color: #003566; color: white; padding: 8px; text-align: left; text-transform: uppercase; font-size: 9px; }
        .summary-table td { padding: 10px; border: 1px solid #cbd5e1; font-size: 12px; font-weight: bold; text-align: center; }
        .acreditacion-val { color: #059669; }

        /* Listado de Movimientos */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { background-color: #f1f5f9; border-bottom: 2px solid #cbd5e1; padding: 8px; font-size: 9px; text-transform: uppercase; text-align: left; }
        .data-table td { padding: 8px; border-bottom: 1px solid #e2e8f0; font-size: 10px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* Firmas */
        .signature-section { margin-top: 50px; width: 100%; }
        .sig-box { width: 45%; text-align: center; border-top: 1px solid #333; padding-top: 10px; font-weight: bold; font-size: 10px; text-transform: uppercase; }
        
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 8px; color: #94a3b8; }
    </style>
</head>
<body>

    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td>
                    <div class="u-name">Universidad Privada de Santa Cruz</div>
                    <div style="font-size: 9px; color: #64748b;">Dirección de Investigación y Acreditación</div>
                </td>
                <td class="doc-title">
                    Estado de Ejecución Financiera<br>
                    <span style="font-size: 10px; color: #003566;">#{{ $proyecto->CodigoProyecto }}</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="project-box">
        <div class="project-title">{{ $proyecto->Nombreproyecto }}</div>
        <table style="width: 100%; font-size: 9px;">
            <tr>
                <td><strong>UNIDAD ACADÉMICA:</strong> {{ $proyecto->carrera->Nombrecarrera ?? 'N/A' }}</td>
                <td style="text-align: right;"><strong>ESTADO:</strong> {{ $proyecto->Estado }}</td>
            </tr>
            <tr>
                <td><strong>LÍNEA:</strong> {{ $proyecto->linea->Nombrelineainvestigacion ?? 'N/A' }}</td>
                <td style="text-align: right;"><strong>FECHA REPORTE:</strong> {{ date('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>

    {{-- Cuadro de Resumen Rápido --}}
    <table class="summary-table">
        <thead>
            <tr>
                <th>Total Inversión (Bs.)</th>
                <th>Monto Validado Acreditación</th>
                <th>Fondos Institucionales</th>
                <th>Aportes Propios/Externos</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ number_format($proyecto->presupuestos->sum('MontoAsignado'), 2) }}</td>
                <td class="acreditacion-val">{{ number_format($proyecto->total_invertido, 2) }}</td>
                <td>{{ number_format($proyecto->presupuestos->where('Modalidad', 'Institucional')->sum('MontoAsignado'), 2) }}</td>
                <td>{{ number_format($proyecto->presupuestos->whereIn('Modalidad', ['Independiente', 'Reembolsable'])->sum('MontoAsignado'), 2) }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Detalle Transaccional --}}
    <h3 style="text-transform: uppercase; font-size: 10px; border-left: 3px solid #003566; padding-left: 10px;">Detalle Cronológico de Gastos e Inversiones</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Fuente de Financiamiento</th>
                <th>Modalidad</th>
                <th class="text-center">Acred.</th>
                <th class="text-right">Monto (Bs.)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proyecto->presupuestos->sortByDesc('FechaAsignacion') as $mov)
            <tr>
                <td>{{ $mov->FechaAsignacion->format('d/m/Y') }}</td>
                <td>
                    <strong>{{ $mov->fondo->NombreFondo ?? 'Gasto Directo' }}</strong><br>
                    <span style="font-size: 8px; color: #666;">{{ $mov->fondo->entidad->NombreEntidad ?? 'Externo' }}</span>
                </td>
                <td>{{ $mov->Modalidad }}</td>
                <td class="text-center">{{ $mov->ValidacionAcreditacion ? 'SÍ' : 'NO' }}</td>
                <td class="text-right"><strong>{{ number_format($mov->MontoAsignado, 2) }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Sección de Firmas --}}
    <table class="signature-section">
        <tr>
            <td class="sig-box" style="width: 40%;">
                Investigador Responsable<br>
                {{ $proyecto->equipo->where('pivot.EsResponsable', 1)->first()->Nombrecompleto ?? 'Firma Autorizada' }}
            </td>
            <td style="width: 20%;"></td>
            <td class="sig-box" style="width: 40%;">
                Vo.Bo. Dirección de Investigación<br>
                SIA v4.0 System Validation
            </td>
        </tr>
    </table>

    <div class="footer">
        Este documento es un reporte oficial generado por el Sistema Integrado de Acreditación (SIA).<br>
        La veracidad de los montos está sujeta a la auditoría de los documentos de respaldo digitales vinculados.
    </div>

</body>
</html>