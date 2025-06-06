<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYearCourseMateria extends Model
{
    use HasFactory;
    protected $table = 'subject_academic_courses';

    protected $fillable = [
        'academic_year_course_id',
        'materia_id',
        'created_at',
        'updated_at'
    ];

    public function AcademicCourse()
    {
        return $this->hasOne(AcademicYearCourses::class);
    }

    public function Subject()
    {
        return $this->hasOne(Materias::class);
    }
}
