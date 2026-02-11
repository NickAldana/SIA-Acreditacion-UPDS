<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Personalmateria extends Pivot
{
    // Configuración especial para Pivote con ID propio (Identity)
    protected $table = 'Personalmateria';
    protected $primaryKey = 'PersonalmateriaID';
    public $timestamps = false;
    public $incrementing = true; 

    protected $fillable = [
        'Gestion',
        'Periodo',
        'Grupo',
        'Modalidad',
        'RutaAutoevaluacion', // ¡CRÍTICO! Debe coincidir con tu BD
        'NotaEvaluacion',
        'PersonalID',
        'MateriaID'
    ];

    // Relaciones para acceder a los padres desde la pivote
    public function personal() { return $this->belongsTo(Personal::class, 'PersonalID'); }
    public function materia() { return $this->belongsTo(Materia::class, 'MateriaID'); }
}