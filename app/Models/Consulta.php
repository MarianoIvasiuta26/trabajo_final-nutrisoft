<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Consulta extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    //use SoftDeletes;

    protected $fillable = [
        'turno_id',
        'nutricionista_id',
        'peso_actual',
        'altura_actual',
        'circunferencia_munieca_actual',
        'circunferencia_cintura_actual',
        'circunferencia_cadera_actual',
        'circunferencia_pecho_actual',
        'diagnostico',
    ];

    public function turno(){
        return $this->belongsTo('App\Models\Turno');
    }

    public function nutricionista(){
        return $this->belongsTo('App\Models\Nutricionista');
    }

    public function medicionesDePlieguesCutaneos() {
        return $this->hasMany(MedicionesDePlieguesCutaneos::class);
    }

    public function planAlimentaciones(){
        return $this->hasMany('App\Models\PlanAlimentaciones');
    }

    public function diagnostico(){
        return $this->hasOne('App\Models\Diagnostico');
    }

    public function planesDeSeguimiento(){
        return $this->hasMany('App\Models\PlanesDeSeguimiento');
    }
}
