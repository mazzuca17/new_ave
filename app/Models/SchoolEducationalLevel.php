<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolEducationalLevel extends Model
{
    use HasFactory;
    protected $table = 'school_educational_levels';
    protected $fillable = [

        'school_id',
        'educational_level_id',
        'active',
        'created_at',
        'updated_at'
    ];
}
