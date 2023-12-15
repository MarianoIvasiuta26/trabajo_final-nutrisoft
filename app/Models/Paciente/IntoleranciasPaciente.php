<?php

namespace App\Models\Paciente;

use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntoleranciasPaciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'intolerancia_id',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function intolerancia()
    {
        return $this->belongsTo(Intolerancia::class);
    }
}
