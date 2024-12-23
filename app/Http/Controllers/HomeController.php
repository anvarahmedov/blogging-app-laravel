<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index() {


        $featuredPosts= Post::published()->featured()->with('categories')->latest(column: 'published_at')->take(value: 3)->get();

        $latestPosts = Post::published()->with('categories')->latest('published_at')->take(9)->get();

        return view("home", [
            'featuredPosts' => $featuredPosts,
            'latestPosts' => $latestPosts
        ]);
    }
}
