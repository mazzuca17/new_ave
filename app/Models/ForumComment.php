<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'forum_message_id',
        'user_id',
        'body',
    ];

    public function message()
    {
        return $this->belongsTo(ForumMessage::class, 'forum_message_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
