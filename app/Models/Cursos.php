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
        'created_at',
        'updated_at'
    ];

    public function school()
    {
        return $this->hasOne(Schools::class, 'school_id');
    }

    public function materias()
    {
        return $this->hasMany(Materias::class, 'curso_id');
    }

    public function eventos()
    {
        return $this->hasMany(Eventos::class, 'curso_id');
    }

    public function students()
    {
        return $this->hasMany(Students::class, 'curso_id');
    }
}
