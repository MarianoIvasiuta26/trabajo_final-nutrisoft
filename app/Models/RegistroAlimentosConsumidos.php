<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegistroAlimentosConsumidos extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'plan_de_seguimiento_id',
        'paciente_id',
        'alimento_id',
        'cantidad',
        'unidad_medida',
        'fecha_consumida',
    ];

    public function planDeSeguimiento()
    {
        return $this->belongsTo(PlanesDeSeguimiento::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function alimento()
    {
        return $this->belongsTo(Alimento::class);
    }

}
