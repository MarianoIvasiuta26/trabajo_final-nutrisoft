<?php

namespace App\Models\Paciente;

use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatologiasPaciente extends Model
{
    use HasFactory;

    protected $fillable =[
        'paciente_id',
        'patologia_id',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function patologia()
    {
        return $this->belongsTo(Patologia::class);
    }
}
