<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\Bitacora;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de login.
     */
    public function showLoginForm()
    {
        // Evita que un usuario ya logueado vea el login
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    /**
     * Procesa la autenticación del usuario.
     */
    public function login(Request $request)
    {
        // 1. Validación de entradas
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'El correo institucional es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
            'email.email' => 'Por favor, ingrese un correo válido.'
        ]);

        $remember = $request->filled('remember');

        // 2. Intento de autenticación
        // Laravel usará 'Correo' para buscar y comparará con 'Contraseña' gracias a getAuthPassword() en el modelo
        if (Auth::attempt([
            'Correo' => $request->email, 
            'password' => $request->password
        ], $remember)) {
            
            $user = Auth::user();

            // 3. Verificación de Estado Activo
            if (!$user->Activo) { 
                // Registramos el ID del usuario aunque se le deniegue el acceso
                Bitacora::registrar(
                    'LOGIN_BLOQUEADO', 
                    "Intento de ingreso con cuenta desactivada: {$user->Correo}", 
                    $user->UsuarioID
                );

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Su cuenta ha sido desactivada por el Vicerrectorado.',
                ])->withInput();
            }

            // 4. Éxito: Regenerar sesión (Seguridad contra fijación de sesiones)
            $request->session()->regenerate();
            
            // Registro de auditoría exitoso
            Bitacora::registrar('LOGIN', "Inicio de sesión exitoso desde IP: " . $request->ip());

            return redirect()->intended('dashboard');
        }

        // 5. Fallo de credenciales
        // Registramos el error sin UsuarioID (porque no sabemos quién es realmente)
        Bitacora::registrar('LOGIN_ERROR', "Credenciales incorrectas para el correo: {$request->email}");

        throw ValidationException::withMessages([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }

    /**
     * Cierra la sesión del sistema.
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            $correo = Auth::user()->Correo;
            
            // Registrar salida antes de destruir la sesión
            Bitacora::registrar('LOGOUT', "Sesión cerrada por el usuario: {$correo}");
        }

        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirección a la ruta 'welcome' definida en tus rutas
        return redirect()->route('welcome');
    }
}