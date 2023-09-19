<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoAlimento extends Model
{
    use HasFactory;

    protected $fillable = [
        'grupo',
    ];

    public function alimento(){
        return $this->hasMany('App\Models\Alimento');
    }
}
