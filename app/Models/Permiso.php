<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;

    protected $table = 'Permisos';
    protected $primaryKey = 'PermisosID'; // Corregido según tu estructura
    public $timestamps = false;

    protected $fillable = ['Nombrepermiso', 'Descripcion'];

    /**
     * Relación inversa con Cargos
     */
    public function cargos()
    {
        return $this->belongsToMany(Cargo::class, 'Cargopermiso', 'PermisosID', 'CargoID')
                    ->using(Cargopermiso::class);
    }
}