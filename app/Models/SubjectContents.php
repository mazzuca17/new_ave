<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectContents extends Model
{
    use HasFactory;

    protected $table = 'subject_contents';

    protected $fillable = [
        'subject_course_id',
        'title',
        'category',
        'description',
        'link',
        'file_path',
    ];
}
