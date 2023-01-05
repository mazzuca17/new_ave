<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schools extends Model
{
    use HasFactory;

    protected $table    = 'schools';
    protected $fillable = ['name', 'description', 'image_profile', 'user_id'];


    /**
     * user
     *
     * @author Matías
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id');
    }
}
