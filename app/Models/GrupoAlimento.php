<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GrupoAlimento extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'grupo',
    ];

    public function alimento(){
        return $this->hasMany('App\Models\Alimento');
    }
}
