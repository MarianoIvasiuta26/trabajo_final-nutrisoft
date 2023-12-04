<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cirugia extends Model
{
    use HasFactory;

    protected $fillable = [
        'cirugia',
        'grupo_cirugia',
    ];
    public function datosMedicos(){
        return $this->hasMany('App\Models\Paciente\DatosMedicos');
    }

    public function cirugiasPaciente(){
        return $this->hasMany('App\Models\Paciente\CirugiasPaciente');
    }

    public function actividadesProhibidasCirugias(){
        return $this->hasMany('App\Models\Paciente\ActividadesProhibidasCirugia');
    }
}
