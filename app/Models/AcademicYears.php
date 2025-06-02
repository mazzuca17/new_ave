<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYears extends Model
{
    use HasFactory;
    const STATUS_ACTIVE    = 1;
    const STATUS_COMMING   = 2;
    const STATUS_DESACTIVE = 0;

    public const ERROR_MESSAGE_VALIDATOR = 'Error al intentar registrar el ciclo lectivo. Por favor, intente más tarde.';
    public const MESSAGE_CICLOLECTIVO_SUCCESS = 'Ciclo lectivo registrado satisfactoriamente.';
    public const MESSAGE_UPDATED_CICLOLECTIVO_SUCCESS = 'Ciclo lectivo actualizado satisfactoriamente.';

    protected $table = 'academic_years';

    protected $fillable = [
        'school_id',
        'name',
        'start_date',
        'end_date',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function Cursos()
    {
        return $this->hasMany(AcademicYearCourses::class, 'academic_year_id');
    }

    /**
     * getStatus
     *
     * @param integer $status
     * @return string
     */
    public static function getStatus(int $status): string
    {
        $statuses = [
            self::STATUS_ACTIVE => 'Activo',
            self::STATUS_COMMING => 'Próximo',
            self::STATUS_DESACTIVE => 'Inactivo',
        ];
        return $statuses[$status] ?? 'Desconocido';
    }
}
