<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alimento extends Model
{
    use HasFactory;

    protected $fillable = [
        'alimento',
        'grupo_alimento_id',
        'estacional',
        'estacion',
    ];

    public function anamnesisAlimentaria(){
        return $this->hasMany('App\Models\Paciente\AnamnesisAlimentaria');
    }

    public function valorNutricional(){
        return $this->hasMany('App\Models\ValorNutricional');
    }

    public function grupoAlimento(){
        return $this->belongsTo('App\Models\GrupoAlimento');
    }

    public function fuenteAlimento(){
        return $this->belongsToMany('App\Models\FuenteAlimento');
    }

    public function nutrientes(){
        return $this->belongsToMany('App\Models\Nutriente');
    }

    public function detallePlanAlimentaciones(){
        return $this->belongsToMany('App\Models\DetallePlanAlimentaciones');
    }

    public function alimentoPorTipoDeDietas(){
        return $this->hasMany('App\Models\AlimentoPorTipoDeDieta');
    }

}
