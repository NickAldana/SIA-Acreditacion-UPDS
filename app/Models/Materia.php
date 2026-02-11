<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    // 1. Configuración V3.1
    protected $table = 'Materia';
    protected $primaryKey = 'MateriaID';
    public $timestamps = false;

    // 2. CAMPOS (CORREGIDO)
    // Quitamos 'CarreraID' porque NO es una columna física en esta tabla.
    protected $fillable = [
        'Sigla',          // Ej: INF110
        'Nombremateria',  // Ej: Estructuras de Datos I
    ];

    // ========================================================================
    // RELACIONES
    // ========================================================================

    /**
     * RELACIÓN CORREGIDA (N:M)
     * Una materia está vinculada a carreras mediante la tabla 'Materiacarrera'.
     * Usamos belongsToMany en lugar de belongsTo.
     */
    public function carreras()
    {
        return $this->belongsToMany(
            Carrera::class, 
            'Materiacarrera', // Nombre exacto de tu tabla intermedia
            'MateriaID',      // FK de este modelo en la pivote
            'CarreraID'       // FK del otro modelo en la pivote
        );
    }

    /**
     * Carga Horaria: ¿Quién dicta esta materia?
     * Tabla Pivote: Personalmateria
     */
    public function docentes()
    {
        return $this->belongsToMany(Personal::class, 'Personalmateria', 'MateriaID', 'PersonalID')
                    ->withPivot('PersonalmateriaID', 'Gestion', 'Periodo', 'RutaAutoevaluacion')
                    ->as('asignacion'); 
    }

    // ========================================================================
    // SCOPES
    // ========================================================================

    public function scopePorSigla($query, $sigla)
    {
        return $query->where('Sigla', 'LIKE', "%$sigla%");
    }
}