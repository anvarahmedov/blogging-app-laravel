<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentToPost extends Component
{
    use WithPagination;

    public Post $post;

    public $loadMore = false;

    #[Rule('required|min:3|max:200')]
    public string $comment;

    public function postComment()
    {
        if (auth()->guest()) {
            return;
        }

        $this->validateOnly('comment');




        $this->post->comments()->create([
            'content' => $this->comment,
            'user_id' => auth()->id()
        ]);

        $this->reset('comment');
    }

    #[Computed()]
    public function comments()
    {
        return $this?->post?->comments()->with('user')->latest()->paginate(5);
    }

    public function deleteComment(Comment $comment) {
        $comment->delete();
        session()->flash('message', 'Comment deleted successfully');
    }





    public function render()
    {
        return view('livewire.comment-to-post');
    }
}
