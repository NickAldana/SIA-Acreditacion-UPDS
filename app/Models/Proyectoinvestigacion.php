<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyectoinvestigacion extends Model
{
    use HasFactory;

    protected $table = 'Proyectoinvestigacion';
    protected $primaryKey = 'ProyectoinvestigacionID';
    
    // DESACTIVADO: Evita el error de columna inexistente en SQL Server
    public $timestamps = false; 

    protected $fillable = [
        'CodigoProyecto',
        'Nombreproyecto',
        'Fechainicio',
        'Fechafinalizacion',
        'Estado',
        'CarreraID',
        'LineainvestigacionID'
    ];

    // Mantenemos los casts para que Eloquent maneje los objetos Carbon automáticamente
    protected $casts = [
        'Fechainicio'       => 'date:Y-m-d',
        'Fechafinalizacion' => 'date:Y-m-d',
    ];

    // ========================================================================
    // RELACIONES
    // ========================================================================

    /**
     * Relación con la Unidad Académica / Carrera.
     */
    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'CarreraID', 'CarreraID');
    }

    /**
     * Relación con la Línea de Investigación Institucional.
     */
    public function linea()
    {
        return $this->belongsTo(Lineainvestigacion::class, 'LineainvestigacionID', 'LineainvestigacionID');
    }

    /**
     * Relación con el Personal asignado al proyecto (Muchos a Muchos).
     */
    public function equipo()
    {
        return $this->belongsToMany(Personal::class, 'Personalproyecto', 'ProyectoinvestigacionID', 'PersonalID')
                    ->withPivot('Rol', 'EsResponsable', 'FechaInicio', 'FechaFin')
                    ->using(Personalproyecto::class);
    }

    /**
     * Relación con las Publicaciones vinculadas al proyecto.
     */
    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class, 'ProyectoinvestigacionID', 'ProyectoinvestigacionID');
    }

    /**
     * Relación con los registros de presupuesto (Dashboard Financiero).
     */
    public function presupuestos()
    {
        // FK: ProyectoinvestigacionID, LocalKey: ProyectoinvestigacionID
        return $this->hasMany(PresupuestoProyecto::class, 'ProyectoinvestigacionID', 'ProyectoinvestigacionID');
    }

    // ========================================================================
    // ACCESSORS (ATRIBUTOS CALCULADOS)
    // ========================================================================

    /**
     * Obtiene la suma total de montos validados para acreditación.
     * Uso en Blade: {{ $proyecto->total_invertido }}
     */
    public function getTotalInvertidoAttribute()
    {
        return $this->presupuestos()
                    ->where('ValidacionAcreditacion', 1)
                    ->sum('MontoAsignado');
    }
}