<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $fillable = ['title', 'slug', 'text_color', 'bg_color'];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    

    public function getExcerpt()
    {
        return Str::limit(strip_tags($this->body), 150);
    }
}
