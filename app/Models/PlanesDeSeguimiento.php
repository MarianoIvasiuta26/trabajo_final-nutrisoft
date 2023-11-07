<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanesDeSeguimiento extends Model
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

    public function detallesPlanesSeguimiento()
    {
        return $this->hasMany(DetallesPlanesSeguimiento::class);
    }

    public function registroAlimentosConsumidos()
    {
        return $this->hasMany(RegistroAlimentosConsumidos::class);
    }

}
