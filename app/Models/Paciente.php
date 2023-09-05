<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dni',
        'telefono',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function historiaClinica()
    {
        return $this->hasOne('App\Models\Paciente\HistoriaClinica');
    }
}
