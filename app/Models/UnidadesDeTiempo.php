<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadesDeTiempo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_unidad_tiempo',
    ];

    public function recetas()
    {
        return $this->hasMany(Receta::class);
    }
}
