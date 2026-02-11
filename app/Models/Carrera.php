<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;

    // 1. Configuración de Tabla
    protected $table = 'Carrera';
    protected $primaryKey = 'CarreraID';
    public $timestamps = false;

    // 2. Campos asignables
    protected $fillable = [
        'CodigoCarrera', 
        'Nombrecarrera', 
        'FacultadID',    
        'IndicadoresID'
    ];

    // ========================================================================
    // RELACIONES (PADRES)
    // ========================================================================

    public function facultad()
    {
        return $this->belongsTo(Facultad::class, 'FacultadID', 'FacultadID');
    }

    public function indicadores()
    {
        return $this->belongsTo(Indicadores::class, 'IndicadoresID', 'IndicadoresID');
    }

    // ========================================================================
    // RELACIONES (HIJOS)
    // ========================================================================

    /**
     * CORRECCIÓN CRÍTICA: Relación N:M
     * Una carrera tiene muchas materias a través de la tabla pivote 'Materiacarrera'.
     * Usamos belongsToMany en lugar de hasMany.
     */
    public function materias()
    {
        return $this->belongsToMany(
            Materia::class, 
            'Materiacarrera', // Tabla intermedia
            'CarreraID',      // FK de este modelo (Carrera) en la pivote
            'MateriaID'       // FK del otro modelo (Materia) en la pivote
        );
    }

    /**
     * Relación: Proyectos de investigación.
     * (Esta SÍ se queda como hasMany, porque la tabla 'Proyectoinvestigacion'
     * tiene la columna 'CarreraID' físicamente).
     */
    public function proyectos()
    {
        return $this->hasMany(Proyectoinvestigacion::class, 'CarreraID', 'CarreraID');
    }
}