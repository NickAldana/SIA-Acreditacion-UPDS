<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Cargopermiso extends Pivot
{
    protected $table = 'Cargopermiso';
    protected $primaryKey = 'CargopermisoID';
    public $timestamps = false;
    public $incrementing = true; // Necesario porque tiene su propia PK Identity

    protected $fillable = [
        'CargoID', 
        'PermisosID'
    ];

    /**
     * Relación directa con Cargo
     */
    public function cargo() 
    { 
        return $this->belongsTo(Cargo::class, 'CargoID'); 
    }

    /**
     * Relación directa con Permiso
     */
    public function permiso() 
    { 
        return $this->belongsTo(Permiso::class, 'PermisosID'); 
    }
}