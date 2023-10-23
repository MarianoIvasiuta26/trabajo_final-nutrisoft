<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicionesDePlieguesCutaneos extends Model
{
    use HasFactory;

    protected $fillable = [
        'historia_clinica_id',
        'consulta_id',
        'tipos_de_pliegue_cutaneo_id',
        'valor_medicion',
    ];

    public function historiaClinica(){
        return $this->belongsTo('App\Models\Paciente\HistoriaClinica');
    }

    public function consulta(){
        return $this->belongsTo(Consulta::class);
    }

    public function tiposDePliegueCutaneos(){
        return $this->belongsTo(TiposDePliegueCutaneo::class);
    }
}
