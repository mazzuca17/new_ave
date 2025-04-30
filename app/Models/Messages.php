<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Messages extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'messages';
    protected $fillable = [
        'school_id',
        'sender_user_id',
        'to_user_id',
        'is_read',
        'subject',
        'content',
        'created_at',
        'updated_at'
    ];

    public function school()
    {
        return $this->hasOne(Schools::class, 'school_id');
    }


    /**
     * Relación con el usuario remitente.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }

    /**
     * Relación con el usuario destinatario (si aplica).
     */
    public function recipient()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
