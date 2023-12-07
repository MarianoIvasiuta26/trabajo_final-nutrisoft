<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class DetallePlanAlimentaciones extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    //use SoftDeletes;

    protected $fillable = [
        'plan_alimentacion_id',
        'alimento_id',
        'horario_consumicion',
        'cantidad',
        'unidad_medida',
        'observacion',
        'usuario',
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
