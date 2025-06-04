<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYearCourseStudent extends Model
{
    use HasFactory;
    protected $table = 'student_enrollments';

    protected $fillable = [
        'academic_year_course_id',
        'student_id'
    ];

    public function academicYearCourse()
    {
        return $this->belongsTo(AcademicYearCourses::class, 'academic_year_course_id');
    }

    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id');
    }
}
