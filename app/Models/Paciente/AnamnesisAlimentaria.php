<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnamnesisAlimentaria extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'historia_clinica_id',
        'alimento_id',
        'gusta'
    ];

    public function historiaClinica(){
        return $this->belongsTo(HistoriaClinica::class);
    }

    public function alimento(){
        return $this->belongsTo('App\Models\Alimento');
    }

}
