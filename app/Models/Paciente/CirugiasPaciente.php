<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CirugiasPaciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'historia_clinica_id',
        'cirugia_id',
        'tiempo',
        'unidad_tiempo',
    ];

    public function historiaClinica()
    {
        return $this->belongsTo(HistoriaClinica::class);
    }

    public function cirugia()
    {
        return $this->belongsTo(Cirugia::class);
    }
}
