<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanAlimentaciones extends Model
{
    use HasFactory;

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
