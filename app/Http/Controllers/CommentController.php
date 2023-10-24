<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    public function store(Request $request, Movie $movie) {

        $request->validate([
            'description' => 'required|string',
        ]);

        Comment::create([
            'description' => $request->input('description'),
            'movie_id' => $movie->id,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('movies.show', $movie);
    }
}
