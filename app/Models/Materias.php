<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materias extends Model
{
    use HasFactory;

    protected $table    = 'materias';
    protected $fillable = [
        'school_id',
        'curso_id',
        'code_materia',
        'nombre',
        'horarios',
        'created_at',
        'updated_at'
    ];

    public function school()
    {
        return $this->hasOne(Schools::class, 'school_id');
    }

    public function cursos()
    {
        return $this->hasMany(Cursos::class, 'curso_id');
    }
}
