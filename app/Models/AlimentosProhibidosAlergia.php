<?php

namespace App\Models;

use App\Models\Paciente\Alergia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlimentosProhibidosAlergia extends Model
{
    use HasFactory;

    protected $fillable = [
        'alergia_id',
        'alimento_id',
    ];

    public function alergia()
    {
        return $this->belongsTo(Alergia::class);
    }

    public function alimento()
    {
        return $this->belongsTo(Alimento::class);
    }
}
