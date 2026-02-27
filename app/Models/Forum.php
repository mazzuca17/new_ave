<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'materia_id',
        'title',
        'description',
        'is_active',
        'created_by',
        'updated_by',
        'disabled_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'disabled_at' => 'datetime',
    ];

    public function materia()
    {
        return $this->belongsTo(Materias::class, 'materia_id');
    }

    public function messages()
    {
        return $this->hasMany(ForumMessage::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
