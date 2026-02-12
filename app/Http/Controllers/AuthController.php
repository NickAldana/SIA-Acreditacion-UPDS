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
        // La clave 'password' es obligatoria para que Laravel active el hasher.
        // El mapeo a la columna 'Password' de la DB se hace en el Modelo Usuario.
        if (Auth::attempt([
            'Correo' => $request->email, 
            'password' => $request->password //
        ], $remember)) {
            
            $user = Auth::user();

            // 3. Verificación de Estado Activo
            if (!$user->Activo) { 
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

            // 4. Éxito: Regenerar sesión y registro de auditoría
            $request->session()->regenerate();
            
            Bitacora::registrar(
                'LOGIN', 
                "Inicio de sesión exitoso desde IP: " . $request->ip(),
                $user->UsuarioID
            );

            return redirect()->intended('dashboard');
        }

        // 5. Fallo de credenciales
        Bitacora::registrar(
            'LOGIN_ERROR', 
            "Credenciales incorrectas para el correo: {$request->email}"
        );

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
            $user = Auth::user();
            
            Bitacora::registrar(
                'LOGOUT', 
                "Sesión cerrada por el usuario: {$user->Correo}",
                $user->UsuarioID
            );
        }

        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }
}