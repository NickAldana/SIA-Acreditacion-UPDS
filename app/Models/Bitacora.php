<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class Bitacora extends Model
{
    protected $table = 'Bitacora';
    protected $primaryKey = 'BitacoraID';
    
    // Desactivamos timestamps automáticos (created_at/updated_at) 
    // porque usas la columna FechaHora
    public $timestamps = false; 

    protected $fillable = [
        'Accion', 
        'Detalle', 
        'IpAddress', 
        'UsuarioID', 
        'FechaHora'
    ];

    // Esto permite que Laravel trate FechaHora como un objeto Carbon automáticamente
    protected $casts = [
        'FechaHora' => 'datetime',
    ];

    /**
     * Relación con el Usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'UsuarioID', 'UsuarioID');
    }
    
    /**
     * Función estática para registrar eventos de forma rápida.
     * * @param string $accion Ejemplo: 'LOGIN', 'CREAR_PROYECTO', 'ERROR'
     * @param string|null $detalle Descripción de lo que pasó
     * @param int|null $usuarioId Opcional, por si quieres forzar un ID específico
     */
    public static function registrar($accion, $detalle = null, $usuarioId = null)
    {
        return self::create([
            'Accion'    => strtoupper($accion), // Siempre en mayúsculas para consistencia
            'Detalle'   => $detalle,
            'IpAddress' => Request::ip() ?? '0.0.0.0',
            // Prioridad: ID pasado por parámetro > ID del usuario logueado > null
            'UsuarioID' => $usuarioId ?? Auth::id(),
            'FechaHora' => now(),
        ]);
    }
}