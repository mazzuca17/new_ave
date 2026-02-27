<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumMessageAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'forum_message_id',
        'file_path',
        'file_name',
        'mime_type',
        'file_size',
    ];

    public function message()
    {
        return $this->belongsTo(ForumMessage::class, 'forum_message_id');
    }
}
