<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Comment;

class CommentLikeButton extends Component
{
    public Comment $comment;

    public function toggleLike() {
        if(auth()->guest()) {
            return $this->redirect(route('login'), true);
        }

        $user = auth()->user();

        if($user->hasLikedComment($this->comment)) {
            $user->commentLikes()->detach($this->comment->id);
            return;
        }

        $user->commentLikes()->attach($this->comment->id);
        //$this->comment->increment('likes');
    }

    public function render()
    {
        return view('livewire.comment-like-button');
    }
}
