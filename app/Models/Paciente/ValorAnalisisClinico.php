<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ValorAnalisisClinico extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'tipo',
        'clase',
        'nombre_valor',
        'medida',
        'rango_valor1',
        'rango_valor2',
    ];

    public function datosMedicos(){
        return $this->hasMany('App\Models\Paciente\DatosMedicos');
    }
}
