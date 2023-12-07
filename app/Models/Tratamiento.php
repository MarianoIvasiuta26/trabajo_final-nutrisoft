<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tratamiento extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'tratamiento',
        'tipo_de_dieta_id',
    ];

    public function tratamientosPorPaciente()
    {
        return $this->hasMany(TratamientoPorPaciente::class);
    }

    public function tipoDeDieta()
    {
        return $this->belongsTo(TiposDeDieta::class);
    }

    public function tiposActividadesPorTratamientos()
    {
        return $this->hasMany(TiposActividadesPorTratamientos::class);
    }

}
