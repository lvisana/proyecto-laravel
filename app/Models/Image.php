<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    public function comments()
    {
        return $this->hasMany('App\Models\Comment')->orderByDesc('created_at');
    }
    public function likes()
    {
        return $this->hasMany('App\Models\Like');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
