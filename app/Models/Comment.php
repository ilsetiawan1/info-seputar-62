<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'content',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Relasi ke Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Relasi ke User (nullable = komentar anonim)
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault(['name' => 'Anonim']);
    }

    // Relasi ke parent comment (nested reply)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Relasi ke child comments (nested reply)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
