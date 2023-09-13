<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alergia extends Model
{
    use HasFactory;

    protected $fillable = [
        'alergia',
        'grupo_alergia',
    ];

    public function datosMedicos(){
        return $this->hasMany('App/Models/Paciente/DatosMedicos');
    }


}
