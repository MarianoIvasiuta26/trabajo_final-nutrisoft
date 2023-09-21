<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoConsulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_consulta',
    ];

    public function turno()
    {
        return $this->hasMany(Turno::class);
    }
}
