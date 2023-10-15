<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index() {
        $movies = Movie::all();
        return view('movie', ['movies' => $movies]);
    }

    public function create() {
        return view('movies.create');
    }

    public function store() {

        return redirect()->route('movie.index');
    }

    public function show() {

    }
}
