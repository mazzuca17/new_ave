<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecords extends Model
{
    use HasFactory;

    protected $table = 'attendance_records';

    protected $fillable = [
        'student_enrollment_id',
        'subject_course_id',
        'date',
        'status',
    ];

    public function enrollment()
    {
        return $this->belongsTo(AcademicYearCourseStudent::class, 'student_enrollment_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materias::class, 'subject_course_id');
    }
}
