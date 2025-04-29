<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'created_at',
    ];

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function likes() {
        return $this->belongsToMany(User::class, 'comment_like')->withTimestamps();
    }

    public function replies() {
        $this->hasMany(Comment::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // In Comment model (Comment.php)
protected static function booted()
{
    static::creating(function ($comment) {
        // Ensure user_id is always set before creating the comment
        if (!$comment->user_id) {
            $comment->user_id = auth()->id();  // Assign the authenticated user ID
        }
    });
}



}
