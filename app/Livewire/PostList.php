<?php

namespace App\Livewire;

use App\Filament\Admin\Resources\PostResource\Widgets\PostPerMonthChart;
use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Post;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\Category;
use App\Filament\Admin\Resources\UserResource\Widgets\UserStatsWidget;

class PostList extends Component
{
    use WithPagination;
    #[Url()]
    public $sort = 'desc';

    #[Url()]
    public $category = '';

    #[Url()]
    public $search = '';

    #[Url]
    public $popular = false;

    public function setSort($sort)
    {
        $this->sort = $sort === 'desc' ? 'desc' : 'asc';
    }


    #[On('search')]
    public function updatedSearch($search)
    {
        $this->search = $search;
        $this->resetPage();
    }



    public function clearFilters() {
        $this->search = '';
        $this->category = '';
        $this->resetPage();
    }


    #[Computed]
    public function posts()
    {
        return Post::published()
    ->when(
        $this->activeCategory(),
        function($query) {
            $query->withCategories($this->category);
        })
    ->with('author', 'categories')
    ->when($this->popular, function ($query) {
        // Using subquery for likes_count to avoid ambiguity
        $query->leftJoin('post_like', 'posts.id', '=', 'post_like.post_id')
              ->selectRaw('posts.*, COUNT(post_like.id) as likes_count')
              ->groupBy('posts.id')
              ->orderByDesc('likes_count'); // Order by the dynamically calculated likes_count
    })
    ->orderBy('published_at', direction: $this->sort)
    ->where('title', 'like', "%{$this->search}%")
    ->paginate(3);
    }

    #[Computed]
    public function activeCategory() {
        if($this->category === null || $this->category === '') {
            return null;
        }
        return Category::where('slug',$this->category)->first();
    }

    public function render()
    {
        return view('livewire.post-list');
    }
}
