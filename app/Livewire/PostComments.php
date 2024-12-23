<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Computed;
use App\Models\Post;

class PostComments extends Component
{
    use WithPagination;

    public Post $post;

    #[Rule('required|min:3|max:200')]
    public string $comment;

    public function postComment()
    {
        if (auth()->guest()) {
            return;
        }

        $this->validateOnly('comment');

        $this->post->comments()->create([
            'comment' => $this->comment,
            'user_id' => auth()->user()->id()
        ]);

        $this->reset('comment');
    }
        #[Computed()]
        public function comments()
    {
        return $this?->post?->comments()->with('user');
    }

    public function render()
    {
        return view('livewire.co');
    }
}
