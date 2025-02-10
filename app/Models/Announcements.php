<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcements extends Model
{
    use HasFactory;
    protected $table = 'announcements';
    protected $fillable = [
        'school_id',
        'title',
        'content',
        'created_at',
        'updated_at'
    ];

    public function school()
    {
        return $this->hasOne(Schools::class, 'school_id');
    }

    public function files()
    {
        return $this->hasMany(AnnouncementFile::class);
    }
}
