<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrientacionCursos extends Model
{
    use HasFactory;
    protected $table    = 'orientacion_cursos';
    protected $fillable = [
        'name',
        'description',
        'school_id',
        'created_at',
        'updated_at'
    ];

    public function school()
    {
        return $this->belongsTo(Schools::class, 'school_id');
    }
}
