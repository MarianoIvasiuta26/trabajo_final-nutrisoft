<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PlanAlimentaciones extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    //use SoftDeletes;

    protected $fillable = [
        'consulta_id',
        'paciente_id',
        'descripcion',
        'estado',
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function detallePlanAlimentaciones()
    {
        return $this->belongsToMany(DetallePlanAlimentaciones::class);
    }
}
