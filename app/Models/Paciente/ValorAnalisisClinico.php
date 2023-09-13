<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValorAnalisisClinico extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'clase',
        'nombre_valor',
        'medida',
        'rango_valor1',
        'rango_valor2',
    ];

    public function datosMedicos(){
        return $this->hasMany('App/Models/Paciente/DatosMedicos');
    }
}
