<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresupuestoProyecto extends Model
{
    protected $table = 'PresupuestoProyecto';
    protected $primaryKey = 'PresupuestoID'; // Ajustado según tu imagen
    public $timestamps = false;

    protected $fillable = [
        'ProyectoinvestigacionID',
        'FondoinversionID',
        'MontoAsignado',
        'FechaAsignacion',
        'Observacion',
        'RutaRespaldoAsignacion',
        'Modalidad',
        'ValidacionAcreditacion'
    ];

    protected $casts = [
        'FechaAsignacion' => 'date',
        'ValidacionAcreditacion' => 'boolean',
        'MontoAsignado' => 'decimal:2'
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyectoinvestigacion::class, 'ProyectoinvestigacionID');
    }

    public function fondo()
    {
        return $this->belongsTo(Fondoinversion::class, 'FondoinversionID');
    }
}