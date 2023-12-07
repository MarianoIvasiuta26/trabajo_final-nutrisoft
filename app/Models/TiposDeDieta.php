<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TiposDeDieta extends Model
{
    use HasFactory;
    //use SoftDeletes;

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
