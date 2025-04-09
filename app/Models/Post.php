<?php

namespace App\Models;

use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\FileExtension;
use Carbon\Carbon;
use Database\Factories\PostFactory;
use Faker\Factory;
use Intervention\Image\Encoders\WebpEncoder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Testing\Fakes\Fake;
use Intervention\Image\Drivers\Gd\Modifiers\ResizeModifier;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;
    use SoftDeletes;
    use WithPagination;

    protected $casts = [
        'published_at' => 'datetime',
    ];
    public $isNull = true;

    public function get_default_img()
    {
        //   $default_img = Post::where('id', rand(1, 100))->first()->image;
        //dd($default_img);
        // while ($default_img === null) {
        $default_img = Post::where('id', '2')->first()->image;
        //  }
        return $default_img;
    }

    protected $fillable = ['user_id', 'title', 'slug', 'image', 'body', 'published_at', 'featured'];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeFeatured($query)
    {
        $query->where('featured', true);
    }

    public function scopePublished($query)
    {
        $query->where('published_at', '<=', Carbon::now());
    }

    public function getExcerpt()
    {
        $regex = '/<a[^>]*>(<img[^>]*>).*?<figcaption[^>]*>.*?<\/figcaption>.*?<\/a>/is';
        $this->body = preg_replace($regex, '$1', $this->body);
        return Str::limit(strip_tags($this->body), 150);
    }

    public function scopePopular($query)
    {
        // dd(request());
        $query->withCount('likes')->orderBy('likes', 'desc');
    }

    public function getReadingTime()
    {
        $mins = round(str_word_count($this->body) / 250);
        return $mins < 1 ? 1 : $mins;
    }

    public function getThumbnailPhoto()
    {
        $isUrl = str_contains($this->image, 'http');


        return $isUrl ? "https://blog-bucket-laravel.s3.amazonaws.com/argentina.png"
        : Storage::disk('s3')->url($this->image);



    // Otherwise, return the current image or generate its URL

    }

    public function scopeWithCategories($query, string $category)
    {
        $query->whereHas('categories', function ($query) use ($category) {
            $query->where('slug', $category);
        });
    }
    //   public function scopeWithCategory($query, string $category)
    //  {
    //       $query->whereHas('category', function ($query) use ($category) {
    //         $query->where('title', $category);
    //      });
    //  }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'post_like')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getComments(Post $post)
    {
        $comments = Comment::where('post_id', $post->id)
            ->take('*')
            ->get();
        return $comments;
    }
}
