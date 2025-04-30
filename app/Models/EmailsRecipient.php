<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailsRecipient extends Model
{
    use HasFactory;
    protected $table = 'emails_recipients';

    protected $fillable = [
        'email_id',
        'recipient_id',
        'is_read',
        'read_at',
        'deleted_at',
    ];

    public function email()
    {
        return $this->belongsTo(Emails::class);
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}
