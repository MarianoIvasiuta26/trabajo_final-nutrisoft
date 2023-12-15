<?php

namespace App\Models\Paciente;

use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlergiasPaciente extends Model
{
    use HasFactory;
    protected $fillable = [
        'paciente_id',
        'alergia_id',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function alergia()
    {
        return $this->belongsTo(Alergia::class);
    }
}
