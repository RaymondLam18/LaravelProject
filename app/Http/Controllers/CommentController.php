<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Pas de 'auth'-middleware toe op alle methoden.
        $this->middleware('auth');
    }

    public function store(Request $request, Movie $movie)
    {
        // Tel het aantal films van de huidige gebruiker.
        $movies = Auth::user()->movies()->count();

        // Controleer of de gebruiker minimaal/gelijk aan 5 films heeft.
        if ($movies >= 5) {
            // Valideer het verzoek voor de beschrijving van de opmerking.
            $request->validate([
                'description' => 'required|string',
            ]);

            // Maak een nieuwe opmerking en koppel deze aan de film en de gebruiker.
            Comment::create([
                'description' => $request->input('description'),
                'movie_id' => $movie->id,
                'user_id' => Auth::id()
            ]);
        }

        // Doorverwijzen naar de weergave van de film.
        return redirect()->route('movies.show', $movie);
    }
}
