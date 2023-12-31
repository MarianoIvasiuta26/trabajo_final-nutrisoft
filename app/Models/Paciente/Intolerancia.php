<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Intolerancia extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'intolerancia',
    ];

    public function datosMedicos(){
        return $this->hasMany('App\Models\Paciente\DatosMedicos');
    }

    public function alimentosProhibidosIntolerancias(){
        return $this->hasMany('App\Models\AlimentosProhibidosIntolerancia');
    }

    public function intoleranciasPacientes(){
        return $this->hasMany('App\Models\Paciente\IntoleranciasPaciente');
    }
}
