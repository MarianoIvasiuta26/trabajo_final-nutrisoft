<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiasAtencion extends Model
{
    use HasFactory;

    protected $fillable = [
        'nutricionista_id',
        'dia',
    ];

    public function nutricionista(){
        return $this->belongsTo('App\Models\Nutricionista');
    }
}
