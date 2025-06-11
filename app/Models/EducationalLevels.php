<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalLevels extends Model
{
    public const ERROR_MESSAGE_VALIDATOR = 'Error al intentar registrar el nivel educativo. Por favor, intente más tarde.';
    public const MESSAGE_EDUCATIONALLEVELS_SUCCESS = 'Nivel educativo registrado satisfactoriamente.';
    public const MESSAGE_UPDATED_EDUCATIONALLEVELS_SUCCESS = 'Nivel educativo actualizado satisfactoriamente.';

    public const MESSAGE_EDUCATIONALLEVELS_ACTIVE_SUCCESS = 'Nivel educativo activado satisfactoriamente.';
    public const MESSAGE_EDUCATIONALLEVELS_ACTIVE_ERROR = 'El nivel educativo no se pudo activar satisfactoriamente, intente más tarde.';

    use HasFactory;

    protected $table = 'educational_levels';
    protected $fillable = [
        'name',
        'description',
        'school_id',
        'created_at',
        'updated_at'
    ];

    public function EducationSchoolLevel()
    {
        return $this->hasMany(SchoolEducationalLevel::class, 'educational_level_id');
    }
}
