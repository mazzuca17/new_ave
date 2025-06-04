<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cursos extends Model
{
    use HasFactory;

    protected $table    = 'cursos';
    protected $fillable = [
        'school_id',
        'name',
        'level',
        'orientation',
        'created_at',
        'updated_at'
    ];

    public function school()
    {
        return $this->belongsTo(Schools::class, 'school_id');
    }

    public function OrientationCourses()
    {
        return $this->hasOne(OrientacionCursos::class, 'id');
    }

    public function materias()
    {
        return $this->hasMany(Materias::class, 'curso_id');
    }

    public function eventos()
    {
        return $this->hasMany(Eventos::class, 'curso_id');
    }


    public function academicYearCourses()
    {
        return $this->hasMany(AcademicYearCourses::class, 'course_id');
    }

    public function studentsInCurrentYear()
    {
        return $this->hasManyThrough(
            Students::class,
            AcademicYearCourseStudent::class,
            'course_id',              // Foreign key on academic_year_course_students
            'id',                     // Foreign key on students
            'id',                     // Local key on cursos
            'student_id'              // Local key on academic_year_course_students
        )->whereHas('academicYearCourse', function ($query) {
            $query->whereHas('academicYear', function ($q) {
                $q->where('current', true); // o cualquier lógica que determine el año lectivo actual
            });
        });
    }
}
