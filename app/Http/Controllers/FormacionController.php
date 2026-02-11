<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formacion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FormacionController extends Controller
{
    /**
     * Registra un nuevo título profesional (Formación Académica).
     */
    public function store(Request $request)
    {
        // 1. VALIDACIÓN
        $request->validate([
            'PersonalID'        => 'required|exists:Personal,PersonalID',
            'CentroformacionID' => 'required|exists:Centroformacion,CentroformacionID',
            'GradoacademicoID'  => 'required|exists:Gradoacademico,GradoacademicoID',
            'Tituloobtenido'    => 'required|string|min:3|max:300',
            'Añosestudios'      => 'required|integer|min:1950|max:' . date('Y'), // Año de graduación
            'archivo'           => 'nullable|file|mimes:pdf|max:5120' // Máx 5MB (Nombre coincide con vista)
        ]);

        // 2. VERIFICACIÓN DE DUPLICADOS
        $duplicado = Formacion::where([
            ['PersonalID', $request->PersonalID],
            ['GradoacademicoID', $request->GradoacademicoID],
            ['Tituloobtenido', $request->Tituloobtenido]
        ])->exists();

        if ($duplicado) {
            return back()->with('error', 'Este grado académico ya está registrado en el expediente.');
        }

        try {
            $datos = $request->except('archivo'); // Excluimos el archivo del array inicial

            // 3. GESTIÓN DE ARCHIVO PDF (Si se subió al crear)
            if ($request->hasFile('archivo')) {
                // Nombre limpio: IDPersonal_Titulo_Timestamp.pdf
                $nombreArchivo = $request->PersonalID . '_titulo_' . time() . '.pdf';
                
                // Guardar en: storage/app/public/titulos
                $ruta = $request->file('archivo')->storeAs('titulos', $nombreArchivo, 'public');
                $datos['RutaArchivo'] = $ruta;
            }

            // 4. CREACIÓN EN BASE DE DATOS
            Formacion::create($datos);

            return redirect()->route('personal.show', $request->PersonalID)
                ->with('success', 'Nueva formación académica registrada correctamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al guardar formación: ' . $e->getMessage());
        }
    }

    /**
     * ACTUALIZACIÓN RÁPIDA DE PDF
     * Recibe el archivo desde el Modal en el perfil del docente.
     */
    public function updatePDF(Request $request)
    {
        // 1. VALIDACIÓN (Coincide con el name="archivo" del modal)
        $request->validate([
            'FormacionID' => 'required|exists:Formacion,FormacionID',
            'archivo'     => 'required|file|mimes:pdf|max:5120' // 5MB Máximo
        ]);

        try {
            $formacion = Formacion::findOrFail($request->FormacionID);

            // 2. BORRAR ARCHIVO ANTERIOR (Limpieza)
            // Si ya existe un PDF, lo borramos para no llenar el disco de basura
            if ($formacion->RutaArchivo && Storage::disk('public')->exists($formacion->RutaArchivo)) {
                Storage::disk('public')->delete($formacion->RutaArchivo);
            }

            // 3. GUARDAR NUEVO ARCHIVO
            // Formato: formacion_ID_timestamp.pdf
            $nombreDoc = 'formacion_' . $formacion->FormacionID . '_' . time() . '.pdf';
            $ruta = $request->file('archivo')->storeAs('titulos', $nombreDoc, 'public');

            // 4. ACTUALIZAR BASE DE DATOS
            $formacion->update([
                'RutaArchivo' => $ruta
            ]);

            return back()->with('success', 'Documento digital actualizado correctamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error técnico al subir el PDF: ' . $e->getMessage());
        }
    }
}