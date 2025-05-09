<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Reactive;

use App\Models\Post;

class LikeButton extends Component
{
    public Post $post;

    public function toggleLike() {
        if(auth()->guest()) {
            return $this->redirect(route('login'), true);
        }

        $user = auth()->user();

        if($user->hasLiked($this->post)) {
            $user->likes()->detach($this->post->id);
            return;
        }

        $user->likes()->attach($this->post->id);
    }

    public function render()
    {
        return view('livewire.like-button');
    }
}
