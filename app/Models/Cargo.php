<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $table = 'Cargo';
    protected $primaryKey = 'CargoID';
    public $timestamps = false;

    // --- ESCALA DE JERARQUÍA (Basada en tu DB) ---
    // 100: Rector
    // 95: Vicerrector
    // 90: Dir. Acreditación
    // 80: Decano
    // 50: Jefe de Carrera
    // 10: Docente

    protected $fillable = [
        'Nombrecargo', 
        'nivel_jerarquico' 
    ];

    protected $casts = [
        'nivel_jerarquico' => 'integer',
    ];

    public function personal()
    {
        return $this->hasMany(Personal::class, 'CargoID', 'CargoID');
    }

    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'Cargopermiso', 'CargoID', 'PermisosID')
                    ->using(Cargopermiso::class);
    }

    /**
     * Accesor inteligente: Convierte el número (0-100) en texto legible.
     */
    public function getNivelLegibleAttribute()
    {
        $n = $this->nivel_jerarquico;

        // Lógica de rangos para abarcar tu estructura actual y futura
        if ($n >= 90) return 'Alta Dirección (Estratégico)'; // Rector, Vice, Dir. Acreditación
        if ($n >= 80) return 'Decanatura (Táctico)';        // Decanos
        if ($n >= 50) return 'Jefatura / Dirección';         // Jefes de Carrera
        if ($n >= 10) return 'Plantel Docente / Operativo';  // Docentes
        
        return 'Personal de Apoyo'; // Menor a 10
    }
}