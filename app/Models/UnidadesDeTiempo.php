<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnidadesDeTiempo extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'nombre_unidad_tiempo',
    ];

    public function recetas()
    {
        return $this->hasMany(Receta::class);
    }
}
