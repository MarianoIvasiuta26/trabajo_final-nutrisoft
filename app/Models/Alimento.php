<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Alimento extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
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

    public function alimentosProhibidosAlergias(){
        return $this->hasMany('App\Models\AlimentosProhibidosAlergia');
    }

    public function alimentosProhibidosIntolerancias(){
        return $this->hasMany('App\Models\AlimentosProhibidosIntolerancia');
    }

    public function alimentosProhibidosPatologias(){
        return $this->hasMany('App\Models\AlimentosProhibidosPatologia');
    }

    public function registroAlimentosConsumidos(){
        return $this->hasMany('App\Models\RegistroAlimentosConsumidos');
    }

    public function ingredientes()
    {
        return $this->hasMany(Ingrediente::class);
    }
}
