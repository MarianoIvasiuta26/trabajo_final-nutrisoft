<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiposDeDieta extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_de_dieta',
    ];

    public function tratamientos()
    {
        return $this->hasMany(Tratamiento::class);
    }

    public function alimentoPorTipoDeDieta(){
        return $this->hasMany(AlimentoPorTipoDeDieta::class);
    }
}
