<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $hidden = ['descripcion','created_at','updated_at'];

    use HasFactory;
    public function cursos()
    {
        return $this->belongsToMany(Curso::class,'cursos_inscritos');
    }
}
