<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formacion extends Model
{
    use HasFactory;

    // 1. Configuración de Tabla
    protected $table = 'Formacion';
    protected $primaryKey = 'FormacionID';
    public $timestamps = false;

    // 2. Mapeo de Columnas (Tal cual tu BD)
    protected $fillable = [
        'NombreProfesion',   
        'Tituloobtenido',    
        'Añosestudios',      
        'RutaArchivo',       
        'CentroformacionID', // FK
        'PersonalID',        // FK
        'GradoacademicoID'   // FK
    ];

    // ========================================================================
    // RELACIONES (AQUÍ ESTABA EL POSIBLE ERROR)
    // ========================================================================

    /**
     * Relación con el Docente
     * Especificamos 'PersonalID' dos veces para evitar que busque 'personal_id'
     */
    public function personal()
    {
        return $this->belongsTo(Personal::class, 'PersonalID', 'PersonalID');
    }

    /**
     * Relación con el Centro de Formación (Universidad)
     * Especificamos 'CentroformacionID' explícitamente
     */
    public function centro()
    {
        return $this->belongsTo(Centroformacion::class, 'CentroformacionID', 'CentroformacionID')
                    ->withDefault(['Nombrecentro' => 'INSTITUCIÓN EXTERNA']); 
                    // withDefault evita error si el ID del centro no existe
    }

    /**
     * Relación con el Grado (Licenciatura, Maestría, etc)
     */
    public function grado()
    {
        return $this->belongsTo(Gradoacademico::class, 'GradoacademicoID', 'GradoacademicoID')
                    ->withDefault(['Nombregrado' => 'GRADO ACADÉMICO']);
    }

    // Helper para verificar PDF en la vista
    public function getTieneEvidenciaAttribute()
    {
        return !empty($this->RutaArchivo);
    }
}