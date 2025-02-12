<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesors extends Model
{
    use HasFactory;
    protected $table = 'profesors';
    protected $fillable = [
        'user_id',
        'school_id',
        'fecha_nacimiento',
        'genero',
        'direccion',
        'telefono',
        'nacionalidad',
        'image_profile',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function school()
    {
        return $this->belongsTo(Schools::class, 'school_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Materias::class, 'subject_teacher', 'teacher_id', 'materia_id');
    }
}
