<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intolerancia extends Model
{
    use HasFactory;

    protected $fillable = [
        'intolerancia',
    ];

    public function datosMedicos(){
        return $this->hasMany('App/Models/Paciente/DatosMedicos');
    }
}
