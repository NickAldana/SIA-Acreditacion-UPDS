<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $table = 'Cargo';
    protected $primaryKey = 'IdCargo';
    public $timestamps = false;

    // 1. AGREGAMOS LA NUEVA COLUMNA AQUI
    // Esto permite que Laravel lea y escriba el nivel desde la base de datos
    protected $fillable = [
        'NombreCargo', 
        'nivel_jerarquico' 
    ];

    // 2. ASEGURAMOS QUE SIEMPRE SEA UN NUMERO
    protected $casts = [
        'nivel_jerarquico' => 'integer',
    ];

    // Relación con Personal
    public function personal()
    {
        return $this->hasMany(Personal::class, 'IdCargo', 'IdCargo');
    }

    // Relación de Permisos
    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'CargoPermiso', 'IdCargo', 'IdPermiso');
    }

    // 3. ACCESOR AUTOMÁTICO
    // Ya no usamos "switch". Simplemente devolvemos el valor que
    // insertaste en la base de datos con tu script SQL.
    public function getNivelJerarquicoAttribute($value)
    {
        return $value ?? 0; // Si es nulo, devuelve 0 por seguridad
    }
}