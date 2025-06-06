<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventos extends Model
{
    use HasFactory;
    const TYPE_GLOBAL = 1;
    const TYPE_PARTICULAR = 2;

    protected $table    = 'eventos';
    protected $fillable = [
        'school_id',
        'user_id',
        'type_id',
        'title',
        'description',
        'fecha',
        'materia_id',
        'curso_id',
        'created_at',
        'updated_at',
        'type_event'
    ];

    /**
     * materia
     *
     * @author Matías
     */
    public function materia()
    {
        return $this->hasOne(Materias::class, 'id', 'materia_id');
    }

    /**
     * schools
     *
     * @author Matías
     */
    public function schools()
    {
        return $this->hasOne(Schools::class, 'id', 'school_id');
    }

    /**
     * author 
     *
     * @author Matías
     */
    public function author()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function TypeEvent()
    {
        return $this->hasOne(TypeEvent::class, 'id', 'type_event');
    }

    /**
     * curso
     *
     * @author Matías
     */
    public function curso()
    {
        return $this->hasOne(Cursos::class, 'id', 'curso_id');
    }

    /**
     * getType
     *
     * @param string $type
     * @author Matías
     */
    public static function getType(string $type)
    {
        return TypeEvent::where('name', $type)->first();
    }
}
