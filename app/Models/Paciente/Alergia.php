<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alergia extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'alergia',
        'grupo_alergia',
    ];

    public function datosMedicos(){
        return $this->hasMany('App\Models\Paciente\DatosMedicos');
    }

    public function alimentosProhibidosAlergias(){
        return $this->hasMany('App\Models\AlimentosProhibidosAlergia');
    }

}
