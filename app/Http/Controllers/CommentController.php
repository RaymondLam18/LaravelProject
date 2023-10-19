<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Movie $movie) {

        $request->validate([
            'description' => 'required|string',
        ]);

        Comment::create([
            'description' => $request->input('description'),
            'post_id' => $movie->id,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('posts.show', $movie);
    }
}
