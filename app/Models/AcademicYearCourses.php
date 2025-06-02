<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYearCourses extends Model
{
    use HasFactory;
    protected $table = 'academic_year_courses';

    protected $fillable = [
        'name',
        'academic_year_id',
        'course_id',
        'created_at',
        'updated_at'
    ];

    public function AcademicYear()
    {
        return $this->hasMany(AcademicYears::class, 'academic_year_id');
    }

    public function Cursos()
    {
        return $this->hasMany(Cursos::class, 'course_id');
    }
}
