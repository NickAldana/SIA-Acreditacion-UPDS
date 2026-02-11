<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuario';
    protected $primaryKey = 'UsuarioID';
    public $timestamps = false;

    /**
     * Caché de permisos por instancia para optimizar el rendimiento (Request Singleton).
     */
    protected $permisosCache = null;

    protected $fillable = [
        'NombreUsuario', 'Correo', 'Contraseña', 'RecordatorioToken', 'Activo', 'Idpersonal'
    ];

    protected $hidden = ['Contraseña', 'RecordatorioToken'];

    protected $casts = [
        'Activo' => 'boolean',
        'Creacionfecha' => 'datetime',
        'Finalfecha' => 'datetime',
    ];

    // --- Autenticación ---
    public function getAuthPassword() { return $this->Contraseña; }
    public function getRememberTokenName() { return 'RecordatorioToken'; }

    // --- Relaciones ---
    public function personal(): HasOne
    {
        return $this->hasOne(Personal::class, 'UsuarioID', 'UsuarioID');
    }

    // ========================================================================
    // MOTOR DE PERMISOS ESCALABLE (SEG-03)
    // ========================================================================

    /**
     * Verifica si el usuario posee un permiso específico.
     * Soporta la creación de nuevos cargos y permisos dinámicamente.
     */
    public function canDo(string $nombrePermiso): bool
    {
        // 1. Filtro de seguridad inmediato
        if (!$this->Activo) return false;

        // 2. Obtener lista de nombres de permisos (Usa la caché interna)
        $misPermisos = $this->getListaPermisos();

        // 3. Validación: Si el cargo tiene 'acceso_total', es Super Admin
        if (in_array('acceso_total', $misPermisos)) return true;

        // 4. Verificación del permiso solicitado
        return in_array($nombrePermiso, $misPermisos);
    }

    /**
     * Centraliza la carga de permisos a través de la cadena:
     * Usuario -> Personal -> Cargo -> Permisos (N:M)
     */
    protected function getListaPermisos(): array
    {
        if ($this->permisosCache !== null) return $this->permisosCache;

        // Si no tiene perfil o cargo asignado, no tiene permisos
        if (!$this->personal || !$this->personal->cargo) {
            return $this->permisosCache = [];
        }

        // Extraemos solo los nombres de los permisos vinculados al Cargo
        // Esto permite que al crear un Cargo nuevo en la web, canDo() lo reconozca al instante.
        $this->permisosCache = $this->personal->cargo->permisos()
                                    ->pluck('Nombrepermiso')
                                    ->toArray();

        return $this->permisosCache;
    }
}