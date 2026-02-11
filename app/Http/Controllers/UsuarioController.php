<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Bitacora;
use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, Auth, DB};

class UsuarioController extends Controller
{
    /**
     * SEG-02: Listado maestro de cuentas de acceso.
     * Carga optimizada con relaciones para evitar el problema N+1.
     */
    public function index(Request $request)
    {
        $query = Usuario::with([
            'personal:PersonalID,Nombrecompleto,CargoID', 
            'personal.cargo:CargoID,Nombrecargo'
        ]);

        // Buscador por Nombre de Usuario o Correo
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('NombreUsuario', 'like', "%{$search}%")
                  ->orWhere('Correo', 'like', "%{$search}%");
            });
        }

        $usuarios = $query->orderBy('UsuarioID', 'desc')->paginate(15);
        
        return view('seguridad.usuarios.index', compact('usuarios'));
    }

    /**
     * Muestra el formulario de edición (SEG-02).
     * Aplica validación jerárquica SEG-04.
     */
    public function edit($id)
    {
        $usuario = Usuario::with('personal.cargo')->findOrFail($id);

        if (!$this->validarJerarquiaUsuario($usuario)) {
            return redirect()->route('usuarios.index')
                ->with('error', 'Acceso denegado: No puede gestionar una cuenta de rango superior.');
        }

        return view('seguridad.usuarios.edit', compact('usuario'));
    }

    /**
     * Actualización de credenciales.
     * Registra cambios en bitácora (SEG-05).
     */
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        if (!$this->validarJerarquiaUsuario($usuario)) {
            return redirect()->route('usuarios.index')->with('error', 'Acción denegada por jerarquía.');
        }

        $request->validate([
            'Correo' => "required|email|unique:usuario,Correo,{$id},UsuarioID",
            'password' => 'nullable|min:8|confirmed',
        ]);

        $usuario->Correo = $request->Correo;

        // Si se define nueva contraseña, aplicar Hash (SEG-01)
        if ($request->filled('password')) {
            $usuario->Contraseña = Hash::make($request->password);
            Bitacora::registrar(
                'cambio_password_admin', 
                "Se cambió manualmente la contraseña del usuario: {$usuario->NombreUsuario}."
            );
        }

        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Cuenta actualizada correctamente.');
    }

    /**
     * SEG-02: Reset de contraseña al CI del docente.
     * Blindado con SEG-04 y SEG-05.
     */
    public function resetPassword($id)
    {
        $usuario = Usuario::with('personal')->findOrFail($id);

        if (!$this->validarJerarquiaUsuario($usuario)) {
            return back()->with('error', 'No tiene permisos para restablecer la clave de un superior.');
        }

        if (!$usuario->personal || !$usuario->personal->Ci) {
            return back()->with('error', 'Este usuario no tiene un registro de personal asociado o CI válido.');
        }

        // Restablecer al CI con Hash Bcrypt
        $usuario->Contraseña = Hash::make($usuario->personal->Ci);
        $usuario->save();

        Bitacora::registrar(
            'reset_password', 
            "Se restableció la contraseña al CI por defecto para: {$usuario->NombreUsuario}."
        );

        return back()->with('success', "La contraseña de {$usuario->NombreUsuario} ha sido restablecida al CI.");
    }

    /**
     * Activar / Bloquear acceso (SEG-02).
     * Sincroniza el estado entre la tabla Usuario y Personal.
     */
    public function toggleStatus($id)
    {
        $usuario = Usuario::findOrFail($id);

        if (!$this->validarJerarquiaUsuario($usuario)) {
            return back()->with('error', 'No puede modificar el estado de un superior.');
        }

        $nuevoEstado = !$usuario->Activo;
        $usuario->Activo = $nuevoEstado;
        $usuario->save();

        // Mantener integridad: si el usuario se bloquea, el perfil de personal también
        if ($usuario->personal) {
            $usuario->personal->Activo = $nuevoEstado;
            $usuario->personal->save();
        }

        $accion = $nuevoEstado ? 'activar_usuario' : 'bloquear_usuario';
        Bitacora::registrar(
            $accion, 
            "El administrador cambió el estado de la cuenta: {$usuario->NombreUsuario}."
        );

        return back()->with('success', $nuevoEstado ? 'Cuenta activada correctamente.' : 'Cuenta bloqueada.');
    }

    /**
     * SEG-04: Lógica privada de protección jerárquica.
     * Impide que usuarios de menor rango gestionen a los de mayor rango.
     */
    private function validarJerarquiaUsuario($targetUser)
    {
        /** @var \App\Models\Usuario $currentUser */
        $currentUser = Auth::user();

        // 1. Super Admin (God Mode) siempre tiene permiso
        if ($currentUser->canDo('acceso_total')) {
            return true;
        }

        // 2. Si no hay datos de cargo, denegar por seguridad
        if (!$currentUser->personal?->cargo || !$targetUser->personal?->cargo) {
            return false;
        }

        // 3. Comparación (Nivel 1: Rector < Nivel 4: Docente)
        // El número menor indica mayor jerarquía.
        return $currentUser->personal->cargo->nivel_jerarquico < $targetUser->personal->cargo->nivel_jerarquico;
    }
}