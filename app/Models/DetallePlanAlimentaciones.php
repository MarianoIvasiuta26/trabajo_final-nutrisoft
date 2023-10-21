<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePlanAlimentaciones extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_alimentacion_id',
        'alimento_id',
        'horario_consumicion',
        'cantidad',
        'unidad_medida',
        'observacion',
    ];

    public function planAlimentaciones()
    {
        return $this->belongsTo(PlanAlimentaciones::class);
    }

    public function alimento()
    {
        return $this->belongsTo(Alimento::class);
    }



}
