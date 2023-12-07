<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoConsulta extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'tipo_consulta',
    ];

    public function turno()
    {
        return $this->hasMany(Turno::class);
    }
}
