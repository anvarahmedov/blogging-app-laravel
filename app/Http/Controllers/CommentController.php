<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use League\CommonMark\Node\Block\Document;

class CommentController extends Controller
{
    public function store(Request $req, Post $post)
    {
        $rules = [
            'content' => 'required|min:3|max:200',
            'parent_id' => 'nullable|exists:comments,id'
        ];
        $validator = Validator::make($req->input(), $rules);

        if ($validator->fails()) {
            if (Str::length($req->get('content')) === 0) {
                return redirect(url()->previous().'#error-comment')->with('error', 'Content field can not be empty');
            } else if(Str::length($req->get('content')) < 3) {
                return redirect(url()->previous().'#error-comment')->with('error', 'Content field length should be at least 3 characters');
            } else {
                return redirect(url()->previous().'#error-comment')->with('error', 'Content field length should not be more than 200 characters');
            }
        }

        $comment = new Comment();
        $comment->post_id = $post->id;
        $comment->content = request()->get('content');
        $comment->user_id = auth()->user()->id;
        $comment->save();

        return redirect()->back()->with('success', 'Comment created successfully');
    }
}
