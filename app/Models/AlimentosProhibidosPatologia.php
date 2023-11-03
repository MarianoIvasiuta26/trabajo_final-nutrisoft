<?php

namespace App\Models;

use App\Models\Paciente\Patologia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlimentosProhibidosPatologia extends Model
{
    use HasFactory;

    protected $fillable = [
        'patologia_id',
        'alimento_id',
    ];

    public function patologia()
    {
        return $this->belongsTo(Patologia::class);
    }

    public function alimento()
    {
        return $this->belongsTo(Alimento::class);
    }
}
