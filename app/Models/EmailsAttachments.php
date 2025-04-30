<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailsAttachments extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'email_id',
        'file_path',
        'file_name',
        'mime_type',
        'uploaded_at',
    ];

    public function email()
    {
        return $this->belongsTo(Emails::class);
    }
}
