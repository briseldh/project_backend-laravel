<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $table = 'post_likes';

    public function user()
    {
        $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function post()
    {
        $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
