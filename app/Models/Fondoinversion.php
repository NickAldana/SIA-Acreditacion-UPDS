<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fondoinversion extends Model
{
    protected $table = 'Fondoinversion';
    protected $primaryKey = 'FondoinversionID';
    public $timestamps = false;

    protected $fillable = [
        'EntidadFinanciadoraID',
        'NombreFondo',
        'CodigoConvenio',
        'MontoTotalFondo',
        'FechaInicio',
        'FechaFin',
        'RutaConvenioPDF'
    ];

    protected $casts = [
        'FechaInicio' => 'date',
        'FechaFin' => 'date',
        'MontoTotalFondo' => 'decimal:2'
    ];

    public function entidad()
    {
        return $this->belongsTo(EntidadFinanciadora::class, 'EntidadFinanciadoraID');
    }

    public function presupuestos()
    {
        return $this->hasMany(PresupuestoProyecto::class, 'FondoinversionID');
    }
}