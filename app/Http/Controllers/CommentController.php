<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
class CommentController extends Controller
{
    public function store(Request $request)
    {
        // Validate the comment data
        $validatedData = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required|string',
        ]);

        // Create the comment
        $comment = new Comment();
        $comment->post_id = $validatedData['post_id'];
        $comment->body = $validatedData['comment'];
        $comment->user_id = Auth::id(); // Associate the comment with the authenticated user
        $comment->save();
        return Redirect::back()->with('success', 'Comment saved successfully.');



    }
}
