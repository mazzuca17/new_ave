<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'sender_id',
        'subject',
        'body',
        'has_attachments',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipients()
    {
        return $this->hasMany(EmailsRecipient::class, 'email_id');
    }

    public function attachments()
    {
        return $this->hasMany(EmailsAttachments::class, 'email_id');
    }
}
