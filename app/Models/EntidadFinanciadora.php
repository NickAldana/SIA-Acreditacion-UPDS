<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntidadFinanciadora extends Model
{
    protected $table = 'EntidadFinanciadora';
    protected $primaryKey = 'EntidadFinanciadoraID';
    public $timestamps = false; // Basado en tu diagrama no parece tener created_at/updated_at

    protected $fillable = [
        'NombreEntidad',
        'TipoEntidad',
        'Nit',
        'ContactoNombre',
        'Activo'
    ];

    public function fondos()
    {
        return $this->hasMany(Fondoinversion::class, 'EntidadFinanciadoraID');
    }
}