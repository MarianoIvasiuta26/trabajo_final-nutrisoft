<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TiposActividadesPorTratamientos extends Model
{
    use HasFactory;
    //use SoftDeletes;

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
