<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectActivities extends Model
{
    use HasFactory;

    protected $table = 'subject_activities';

    protected $fillable = [
        'subject_course_id',
        'title',
        'instructions',
        'due_date',
    ];
}
