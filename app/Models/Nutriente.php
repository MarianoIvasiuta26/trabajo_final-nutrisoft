<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nutriente extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'tipo_nutriente_id',
        'nombre_nutriente',
    ];

    public function tipoNutriente()
    {
        return $this->belongsTo(TipoNutriente::class);
    }

    public function valorNutricional()
    {
        return $this->hasMany(ValorNutricional::class);
    }
}
