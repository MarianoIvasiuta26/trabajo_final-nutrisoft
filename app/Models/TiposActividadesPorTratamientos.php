<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiposActividadesPorTratamientos extends Model
{
    use HasFactory;

    protected $fillable = [
        'tratamiento_id',
        'tipo_actividad_id',
    ];

    public function tratamiento()
    {
        return $this->belongsTo(Tratamiento::class);
    }

    public function tipoDeActividad()
    {
        return $this->belongsTo(TiposDeActividades::class);
    }

}
