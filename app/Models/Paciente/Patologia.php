<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patologia extends Model
{
    use HasFactory;

    protected $fillable = [
        'patologia',
        'grupo_patologia',
    ];
    public function datosMedicos(){
        return $this->hasMany('App/Models/Paciente/DatosMedicos');
    }

    public function alimentosProhibidosPatologias(){
        return $this->hasMany('App/Models/AlimentosProhibidosPatologia');
    }

    public function actividadesProhibidasPatologias(){
        return $this->hasMany('App/Models/ActividadesProhibidasPatologia');
    }
}
