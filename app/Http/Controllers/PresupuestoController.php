<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Storage};
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\{Proyectoinvestigacion, PresupuestoProyecto, Fondoinversion};

class PresupuestoController extends Controller
{
    /**
     * Dashboard Financiero del Proyecto con Filtros
     */
    public function index(Request $request, $proyectoId)
    {
        $proyecto = Proyectoinvestigacion::findOrFail($proyectoId);

        // 1. Consulta con Eager Loading y Filtros Dinámicos
        $query = PresupuestoProyecto::with('fondo.entidad')
            ->where('ProyectoinvestigacionID', $proyectoId)
            ->when($request->fecha_desde, fn($q) => $q->whereDate('FechaAsignacion', '>=', $request->fecha_desde))
            ->when($request->fecha_hasta, fn($q) => $q->whereDate('FechaAsignacion', '<=', $request->fecha_hasta))
            ->when($request->modalidad, fn($q) => $q->where('Modalidad', $request->modalidad))
            ->orderBy('FechaAsignacion', 'desc');

        $movimientos = $query->get();

        // 2. Métricas en tiempo real
        $totales = [
            'asignado'   => $movimientos->sum('MontoAsignado'),
            'acreditable'=> $movimientos->where('ValidacionAcreditacion', 1)->sum('MontoAsignado'),
            'propio'     => $movimientos->whereIn('Modalidad', ['Independiente', 'Reembolsable'])->sum('MontoAsignado'),
            'institucional' => $movimientos->where('Modalidad', 'Institucional')->sum('MontoAsignado')
        ];

        return view('presupuesto.index', compact('proyecto', 'movimientos', 'totales'));
    }

    public function create($proyectoId)
    {
        $proyecto = Proyectoinvestigacion::findOrFail($proyectoId);
        $fondos = Fondoinversion::with('entidad')->where('MontoTotalFondo', '>', 0)->get();
        return view('presupuesto.create', compact('proyecto', 'fondos'));
    }

    /**
     * Registro con Control de Techo Presupuestario
     */
    public function store(Request $request, $proyectoId)
    {
        $request->validate([
            'MontoAsignado'   => 'required|numeric|min:1',
            'Modalidad'       => 'required|in:Institucional,Independiente,Reembolsable',
            'FondoinversionID'=> 'required_if:Modalidad,Institucional',
            'archivo_respaldo'=> 'required|file|mimes:pdf,jpg,png|max:10240', // 10MB para escaneos de alta calidad
            'FechaAsignacion' => 'required|date|before_or_equal:today',
        ]);

        DB::beginTransaction();
        try {
            // Lógica de validación de fondos (Opcional: evitar sobregiro del fondo)
            if ($request->Modalidad === 'Institucional') {
                $fondo = Fondoinversion::findOrFail($request->FondoinversionID);
                if ($request->MontoAsignado > $fondo->MontoTotalFondo) {
                    throw new \Exception("Saldo insuficiente en el fondo: " . $fondo->NombreFondo);
                }
            }

            $ruta = $request->file('archivo_respaldo')->store('respaldos_presupuesto/' . date('Y'), 'public');

            PresupuestoProyecto::create(array_merge($request->all(), [
                'ProyectoinvestigacionID' => $proyectoId,
                'RutaRespaldoAsignacion' => $ruta,
                'ValidacionAcreditacion' => 1,
                'FondoinversionID' => $request->Modalidad === 'Institucional' ? $request->FondoinversionID : 1
            ]));

            DB::commit();
            return redirect()->route('presupuesto.index', $proyectoId)->with('success', 'Movimiento financiero consolidado.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Edición de detalles y reemplazo de comprobantes
     */
    public function update(Request $request, $proyectoId, $id)
    {
        $movimiento = PresupuestoProyecto::findOrFail($id);
        
        $request->validate([
            'MontoAsignado' => 'required|numeric',
            'archivo_respaldo' => 'nullable|file|mimes:pdf,jpg,png|max:10240'
        ]);

        if ($request->hasFile('archivo_respaldo')) {
            // Eliminar el archivo viejo del servidor
            if ($movimiento->RutaRespaldoAsignacion) {
                Storage::disk('public')->delete($movimiento->RutaRespaldoAsignacion);
            }
            $movimiento->RutaRespaldoAsignacion = $request->file('archivo_respaldo')->store('respaldos_presupuesto', 'public');
        }

        $movimiento->update($request->except('archivo_respaldo'));

        return redirect()->route('presupuesto.index', $proyectoId)->with('success', 'Información financiera actualizada.');
    }

    /**
     * Reporte PDF: Estado de Cuentas del Proyecto
     */
    public function reportePDF($proyectoId)
    {
        $proyecto = Proyectoinvestigacion::with('presupuestos.fondo.entidad')->findOrFail($proyectoId);
        
        $pdf = Pdf::loadView('presupuesto.pdf_reporte', compact('proyecto'));
        
        return $pdf->setPaper('letter', 'portrait')
                   ->stream("Estado_Financiero_{$proyecto->CodigoProyecto}.pdf");
    }

    public function toggleValidacion($proyectoId, $id)
    {
        $presupuesto = PresupuestoProyecto::findOrFail($id);
        $presupuesto->update(['ValidacionAcreditacion' => !$presupuesto->ValidacionAcreditacion]);
        return back()->with('info', 'Estatus de validación modificado.');
    }

    public function destroy($proyectoId, $id)
    {
        $presupuesto = PresupuestoProyecto::findOrFail($id);
        if ($presupuesto->RutaRespaldoAsignacion) {
            Storage::disk('public')->delete($presupuesto->RutaRespaldoAsignacion);
        }
        $presupuesto->delete();
        return back()->with('success', 'Registro eliminado del sistema.');
    }
}