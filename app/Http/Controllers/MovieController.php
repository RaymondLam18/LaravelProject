<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
//        $movies = Movie::all();
//        return view('movie', ['movies' => $movies]);
        $movies = Movie::all()->sortByDesc('created_at')->where('status', '=', '1');

        return view('movies.home', compact('movies'));
    }

    /**
     * Display a listing of the resource based on a query
     */
    public function find(Request $request){
//        $request->validate([
//            'query' => 'string'
//        ]);

        $tagsString = $request->input('tags');
        $tags = explode(' ', $tagsString);

        $wildcard = '%' . $request->input('query') . '%';

//        $movies = Movie::where(function ($query) use ($wildcard) {
//            $query->where('title', 'LIKE', $wildcard)
//                ->orWhere('director', 'LIKE', $wildcard)
//                ->orWhere('genre', 'LIKE', $wildcard);
//        })->orderByDesc('created_at')->get();

        $query = Movie::where('status', '=', '1')->with('tags');

        if (!empty($request->input('query'))) {
            $query->where('title', 'LIKE', $wildcard);
        }
        if (!empty($request->input('tags'))) {
            $query->whereHas('tags', function (Builder $query) use ($tags) {
                foreach ($tags as $tag) {
                    $query->where('genre', '=', $tag);
                }
            });
//                ->toSql());
        }
        $movies = $query->get()->sortByDesc('created_at');


        return view('movies.search', compact('movies'));
    }

    public function status(Movie $movie) {
        if (Auth::user()->id !== $movie->user_id) {
            return redirect()->route('movies.index');
        }
        $movie->status = !$movie->status;

        $movie->save();

        return redirect()->route('user.movies');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('movies.create');
//        $likes = Auth::user()->likes()->count();
//        if ($likes >= 5) {
//            return view('movies.create');
//        }
//        return redirect()->route('movies.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $likes = Auth::user()->likes()->count();
//        if ($likes < 5) {
//            return redirect()->route('posts.index');
//        }

        $data = $this->validator($request->all())->validate();

        $filename = '';
        if (isset($data['image'])) {
            $image = $data['image'];
            $filename = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('img/movies'), $filename);
        }

        Movie::create([
            'title' => $data['title'],
            'director' => $data['director'],
            'image' => $filename,
//            'genre' => $data['genre'],
            'description' => $data['description'],
            'status' => 1,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('movies.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
//        return view('movies.show', compact('movie'));
        if ($movie->status != 1) {
            return redirect()->route('movies.index');
        }
        return view('movies.show', compact('movie'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        if (Auth::user()->id !== $movie->user_id) {
            return redirect()->route('movies.index');
        }

        return view('movies.edit', compact('movie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        if (Auth::user()->id !== $movie->user_id) {
            return redirect()->route('movies.index');
        }

        $data = $this->validator($request->all())->validate();

        if (isset($data['image'])) {
            $image = $data['image'];
            $filename = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('img/movies'), $filename);

            File::delete(public_path('img/movies/' . $movie->image));
            $movie->image = $filename;
        }

        $movie->title = $data['title'];

        $movie->director = $data['director'];

//        $movie->genre = $data['genre'];

        $movie->description = $data['description'];

        $movie->save();

        return redirect()->route('user.movies');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        if (Auth::user()->id !== $movie->user_id) {
            return redirect()->route('user.movies');
        }

        $movie->delete();

        return redirect()->route('user.movies');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => ['required', 'string', 'max:255'],
            'director' => ['required', 'string', 'max:255'],
//            'genre' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'image' => ['mimes:jpg,jpeg,png,gif,svg,webp', 'max:10000']
        ]);
    }
}
