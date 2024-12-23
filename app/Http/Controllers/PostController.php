<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Post;
use App\Models\Comment;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PostController extends Controller
{
    use WithPagination;
    public function index()
    {
        $categories = Category::whereHas('posts', function ($query) {
            $query->published();
        })->take(5)
        ->get();
        return view('posts.index', [
            'categories' => $categories,
        ]);
    }

    public function show(Post $post)
    {
        $user = auth()->user();


        $comments = Comment::where('post_id', $post->id)
            ->take('*')
            ->with('user')
            ->latest()->paginate(5);

            $comments_for_pagination = Comment::where('post_id', $post->id)->paginate(5);

        $categories = Category::whereHas('posts', function ($query) {
            $query->published();
        })
            ->take(5)
            ->get();
            $regex = '/<a[^>]*>(<img[^>]*>).*?<figcaption[^>]*>.*?<\/figcaption>.*?<\/a>/is';
            $post->body = preg_replace($regex, '$1', $post->body);
            if (empty($post->image)) {
                $image = \File::allFiles(public_path('images'));
                $post->image = asset('images/' . $image[0]->getFilename());
            }
            return view('posts.show', [
            'post' => $post,
            'comments' => $comments,
            'comments_for_pagination' => $comments_for_pagination,
            'categories' => $categories,
        ]);
    }
}
