<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncementFile extends Model
{
    use HasFactory;

    protected $table    = 'announcements_files';
    protected $fillable = ['announcement_id', 'file_path', 'file_type'];


    public function announcement()
    {
        return $this->belongsTo(Announcements::class);
    }
}
