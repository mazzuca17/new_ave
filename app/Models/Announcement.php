<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'announcements';
    protected $fillable = [
        'school_id',
        'to_user_id',
        'subject',
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
