<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriasProf extends Model
{
    use HasFactory;
    protected $table = 'subject_teacher';
    protected $fillable = [
        'subject_courses_id',
        'teacher_id',
        'created_at',
        'updated_at'
    ];

    public function subject()
    {
        return $this->hasMany(Materias::class, 'subject_courses_id');
    }

    public function teachers()
    {
        return $this->hasMany(Profesors::class, 'id');
    }
}
