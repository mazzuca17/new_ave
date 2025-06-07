<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriasHorarios extends Model
{
    use HasFactory;
    protected $table = 'subject_schedules';
    protected $fillable = [
        'subject_course_id',
        'day_of_week',
        'start_time',
        'end_time',
        'created_at',
        'updated_at'
    ];

    public static function getNumberDayWeek(string $dia): ?int
    {
        $dias = [
            'lunes'     => 1,
            'martes'    => 2,
            'miércoles' => 3,
            'miercoles' => 3,
            'jueves'    => 4,
            'viernes'   => 5,
            'sábado'    => 6,
            'sabado'    => 6,
            'domingo'   => 7,
        ];

        $dia = strtolower(trim($dia));
        return $dias[$dia] ?? null; // devuelve null si no se encuentra
    }

    public static function getDayWeek(int $dia): ?string
    {
        $dias = [
            1 => 'lunes',
            2 => 'martes',
            3 => 'miércoles',
            4 => 'jueves',
            5 => 'viernes',
            6 => 'sábado',
            7 => 'domingo',
        ];

        $dia = strtolower(trim($dia));
        return ucfirst($dias[$dia]) ?? null; // devuelve null si no se encuentra
    }
}
