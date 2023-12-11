<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'name',
        'grupo_tag_id'
    ];

    public function tagsDiagnostico(){
        return $this->hasMany(TagsDiagnostico::class);
    }

    public function grupoTag(){
        return $this->belongsTo(GruposTags::class, 'grupo_tag_id');
    }
}
