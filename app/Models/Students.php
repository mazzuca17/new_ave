<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;
    protected $table =  'students';
    protected $fillable = [
        'user_id',
        'curso_id',
        'school_id',
        'fecha_nacimiento',
        'genero',
        'direccion',
        'telefono',
        'nacionalidad',
        'image_profile',
        'anio_ingreso',
        'promedio',
        'condition',
        'estado_matricula',
        'beca',
        'nombre_tutor',
        'telefono_tutor',
        'alergias',
        'seguro_medico',
        'contacto_emergenciass',

        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function curso()
    {
        return $this->belongsTo(Cursos::class, 'curso_id');
    }

    public function school()
    {
        return $this->belongsTo(Schools::class, 'school_id');
    }
}
