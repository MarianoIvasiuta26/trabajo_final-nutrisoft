<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Turno extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    //use SoftDeletes;

    protected $fillable = [
        'paciente_id',
        'horario_id',
        'tipo_consulta_id',
        'motivo_consulta',
        'estado',
        'fecha',
        'hora',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function horarioAtencion()
    {
        return $this->belongsTo(HorariosAtencion::class);
    }

    public function tipoConsulta()
    {
        return $this->belongsTo(TipoConsulta::class);
    }

    public function consulta()
    {
        return $this->hasOne(Consulta::class);
    }

    public function turnosTemporalesCancelados()
    {
        return $this->hasMany(TurnosTemporales::class, 'turno_id_cancelado');
    }

    public function turnosTemporalesAdelantados()
    {
        return $this->hasMany(TurnosTemporales::class, 'turno_id_adelantado');
    }

}
