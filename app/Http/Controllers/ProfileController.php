<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash, Storage, Cache, DB, Log};
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Muestra el formulario de perfil.
     */
    public function edit()
    {
        /** @var Usuario $user */
        $user = Auth::user();

        // Usamos firstOrFail para asegurar que si el usuario no tiene ficha personal, salte un error 404 controlado
        $docente = $user->personal()
            ->with(['cargo:CargoID,Nombrecargo', 'contrato:TipocontratoID,Nombrecontrato']) // Optimizamos trayendo solo columnas necesarias
            ->firstOrFail();

        return view('profile.edit', compact('docente'));
    }

    /**
     * Procesa la actualización con Transacciones ACID.
     */
    public function update(Request $request)
    {
        /** @var Usuario $user */
        $user = Auth::user();
        $docente = $user->personal;

        // 1. VALIDACIÓN ROBUSTA (Con todos los mensajes traducidos)
        $request->validate([
            'Telelefono' => 'nullable|string|max:20',
            'Fotoperfil' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', 
            'password'   => [
                'nullable', 
                'confirmed', 
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->mixedCase()
                    ->symbols()
                    ->uncompromised(1),
            ], 
        ], [
            // Traducciones completas para evitar mensajes en inglés
            'password.min'           => 'La contraseña debe tener al menos 8 caracteres.',
            'password.letters'       => 'Debe incluir al menos una letra.',
            'password.numbers'       => 'Debe incluir al menos un número.',
            'password.mixed'         => 'Combine letras MAYÚSCULAS y minúsculas.',
            'password.symbols'       => 'Debe incluir al menos un símbolo (ej. @, #, $).',
            'password.uncompromised' => 'Esta contraseña ha aparecido en filtraciones de datos. Por favor elija otra.',
            'password.confirmed'     => 'La confirmación de la contraseña no coincide.',
        ]);

        try {
            // 2. INICIO DE TRANSACCIÓN (Todo o Nada)
            DB::transaction(function () use ($request, $docente, $user) {
                
                // A. Actualizar Celular
                if ($docente->Telelefono !== $request->Telelefono) {
                    $docente->Telelefono = $request->Telelefono;
                    $docente->save();
                }

                // B. Gestión de Foto (Optimizada)
                if ($request->hasFile('Fotoperfil')) {
                    // Borrar foto anterior si existe y no es un directorio
                    if ($docente->Fotoperfil && Storage::disk('public')->exists($docente->Fotoperfil)) {
                        Storage::disk('public')->delete($docente->Fotoperfil);
                    }

                    // Generar nombre único y guardar
                    $file = $request->file('Fotoperfil');
                    $nombreArchivo = 'perfil_' . $user->UsuarioID . '_' . time() . '.' . $file->getClientOriginalExtension();
                    
                    $docente->Fotoperfil = $file->storeAs('fotos/perfiles', $nombreArchivo, 'public');
                    $docente->save();
                }

                // C. Actualizar Contraseña (Usuario)
                if ($request->filled('password')) {
                    $user->Password = Hash::make($request->password); // Columna 'Password' (Mayúscula)
                    $user->save();
                }
            });

            // 3. Limpiar Caché (Solo si la transacción fue exitosa)
            Cache::forget('user_sidebar_data_' . $user->UsuarioID);

            return back()->with('success', 'Perfil actualizado correctamente.');

        } catch (\Exception $e) {
            // Registramos el error real en los logs del servidor para depuración
            Log::error("Error actualizando perfil usuario ID {$user->UsuarioID}: " . $e->getMessage());

            // Mostramos un mensaje genérico al usuario
            return back()->with('error', 'Ocurrió un problema técnico al guardar los cambios. Intente nuevamente.');
        }
    }
}