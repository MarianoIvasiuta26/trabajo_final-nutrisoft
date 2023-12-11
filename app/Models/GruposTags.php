<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GruposTags extends Model
{
    use HasFactory;
    protected $fillable = [
        'grupo_tag'
    ];

    public function tags(){
        return $this->hasMany(Tag::class, 'grupo_tag_id');
    }
}
