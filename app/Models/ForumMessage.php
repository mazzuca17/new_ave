<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'forum_id',
        'user_id',
        'body',
    ];

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments()
    {
        return $this->hasMany(ForumMessageAttachment::class);
    }

    public function comments()
    {
        return $this->hasMany(ForumComment::class)->latest();
    }
}
