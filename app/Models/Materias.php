<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Materias extends Model
{
    use HasFactory;

    protected $table    = 'materias';
    protected $fillable = [
        'school_id',
        'curso_id',
        'code_materia',
        'nombre',
        'created_at',
        'updated_at'
    ];

    public function school()
    {
        return $this->hasOne(Schools::class, 'id');
    }

    public function cursos()
    {
        return $this->belongsTo(Cursos::class, 'curso_id', 'id');
    }

    public function materiasprofesores()
    {
        return $this->hasMany(MateriasProf::class, 'subject_courses_id');
    }


    public function horarios()
    {
        return $this->hasMany(MateriasHorarios::class, 'subject_course_id', 'id');
    }

    public static function calculateHours($start_time, $end_time)
    {
        $start = Carbon::parse($start_time);
        $end = Carbon::parse($end_time);
        return $end->diffInMinutes($start) / 60;
    }
}
