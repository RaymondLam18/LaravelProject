<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use function Laravel\Prompts\select;

class MovieController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Pas de 'auth'-middleware toe op alle methoden, behalve 'index', 'find' en 'show'
        $this->middleware('auth')->except(['index', 'find', 'show', 'details']);
    }

    /**
     * Display a listing of the resource.
     */
//    public function index() {
//        $movies = Movie::all()->sortByDesc('created_at')->where('status', '=', '1');
//
//        return view('movies.home', compact('movies'));
//    }
//    public function index(Request $request) {
//        $genre = $request->input('genre');
//
//        $query = Movie::where('status', '=', '1')->with('tags');
//
//        if (!empty($genre)) {
//            $query->whereHas('tags', function (Builder $query) use ($genre) {
//                $query->where('genre', '=', $genre);
//            });
//        }
//
//        $movies = $query->get()->sortByDesc('created_at');
//
//        return view('movies.home', compact('movies'));
//    }

//    public function index(Request $request)
//    {
//        $genre = $request->input('genre');
//        $query = $request->input('query');
//
//        // Initialiseer de query builder voor Movies
//        $queryBuilder = Movie::where('status', '=', '1')->with('tags');
//
//        if (!empty($genre)) {
//            // Voeg een voorwaarde toe om films te filteren op genre
//            $queryBuilder->whereHas('tags', function (Builder $query) use ($genre) {
//                $query->where('genre', '=', $genre);
//            });
//        }
//
//        if (!empty($query)) {
//            // Voeg een voorwaarde toe om films te zoeken op titel
//            $queryBuilder->where('title', 'LIKE', '%' . $query . '%');
//        }
//
//        // Haal films op en sorteer ze
//        $movies = $queryBuilder->get()->sortByDesc('created_at');
//
//        // Geef de weergave met de lijst van films terug
//        return view('movies.home', compact('movies'));
//    }

    public function index(Request $request) {
        $query = $request->input('query');
        $genre = $request->input('genre');

        if (!empty($query) || !empty($genre)) {
            // Als er een zoekopdracht is, stuur deze door naar de 'find' methode
            return $this->find($request);
        }

        // Als er geen zoekopdracht is, toon alle films
        $movies = Movie::where('status', '=', '1')->with('tags')->get()->sortByDesc('created_at');
        return view('movies.home', compact('movies'));
    }

    /**
     * Display a listing of the resource based on a query
     */
//    public function find(Request $request){
//        $request->validate([
//            'query' => 'string'
//        ]);
//
//        $tagsString = $request->input('tags');
//        $tags = explode(' ', $tagsString);
//
//        $wildcard = '%' . $request->input('query') . '%';
//
//        $query = Movie::where('status', '=', '1')->with('tags');
//
//        if (!empty($request->input('query'))) {
//            $query->where('title', 'LIKE', $wildcard);
//        }
//        if (!empty($request->input('tags'))) {
//            $query->whereHas('tags', function (Builder $query) use ($tags) {
//                foreach ($tags as $tag) {
//                    $query->where('tags_id', '=', $tag);
//                }
//            });
////                ->toSql());
//        }
//        $movies = $query->get()->sortByDesc('created_at');
//
//
//        return view('movies.search', compact('movies'));
//    }

    public function find(Request $request) {
        // Haal genre en zoekopdracht op uit het verzoek.
        $genre = $request->input('genre');
        $query = $request->input('query');

        // Initialiseer de query builder voor Films.
        $queryBuilder = Movie::where('status', '=', '1')->with('tags');

        if (!empty($genre)) {
            // Voeg een voorwaarde toe om films te filteren op genre, indien opgegeven.
            $queryBuilder->whereHas('tags', function (Builder $query) use ($genre) {
                $query->where('genre', '=', $genre);
            });
        }

        if (!empty($query)) {
            // Voeg voorwaarden toe om films te filteren op titel en regisseur, indien opgegeven.
            $queryBuilder->where('title', 'LIKE', '%' . $query . '%')
                ->orWhere('director', 'LIKE', '%' . $query . '%');
        }

        // Haal de gefilterde films op en sorteer ze op aanmaakdatum.
        $movies = $queryBuilder->get()->sortByDesc('created_at');

        // Geef de weergave met de lijst van films terug.
        return view('movies.home', compact('movies'));
    }

    /**
     * Change the status of the movie.
     */
    public function status(Movie $movie)
    {
        if (Auth::user()->id !== $movie->user_id) {
            // Doorverwijzen als de gebruiker geen toestemming heeft om de status te wijzigen
            return redirect()->route('movies.index');
        }

        // Wijzig de status van de film
        $movie->status = !$movie->status;

        $movie->save();

        // Doorverwijzen naar de lijst van films van de gebruiker
        return redirect()->route('user.movies');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Toon het formulier voor het maken van een nieuwe film
        return view('movies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valideer de request data met behulp van een aangepaste validator
        $data = $this->validator($request->all())->validate();

        $filename = '';

        // Upload en sla de filmafbeelding op
        if (isset($data['image'])) {
            $image = $data['image'];
            $filename = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('img/movies'), $filename);
        }

        // Maak een nieuwe film aan
        $movie = Movie::create([
            'title' => $data['title'],
            'director' => $data['director'],
            'image' => $filename,
            'description' => $data['description'],
            'status' => 1,
            'user_id' => Auth::user()->id
        ]);

        // Voeg tags toe aan de film
        unset($data['title'], $data['director'], $data['description'], $data['image']);
        foreach ($data as $item) {
            $movie->tags()->attach($item);
        }

        // Doorverwijzen naar de lijst van films
        return redirect()->route('movies.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        if ($movie->status != 1) {
            // Als de film niet actief is, doorverwijzen naar de filmlijst.
            return redirect()->route('movies.index');
        }
        // Als de film actief is, toon de details van de film.
        return view('movies.show', compact('movie'));
    }

    public function details($id)
    {
        $movie = Movie::find($id);

        return view('movies.movie-details', compact('movie'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        if (Auth::user()->id !== $movie->user_id) {
            // Als de huidige gebruiker niet de eigenaar is, doorverwijzen naar de filmlijst.
            return redirect()->route('movies.index');
        }
        // Als de huidige gebruiker de eigenaar is, toon het bewerkingsformulier voor de film.
        return view('movies.edit', compact('movie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        if (Auth::user()->id !== $movie->user_id) {
            // Als de huidige gebruiker niet de eigenaar is, doorverwijzen naar de filmlijst.
            return redirect()->route('movies.index');
        }

        $data = $this->validator($request->all())->validate();

        if (isset($data['image'])) {
            $image = $data['image'];
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/movies'), $filename);

            // Verwijder de oude afbeelding als een nieuwe wordt geüpload
            File::delete(public_path('img/movies/' . $movie->image));
            $movie->image = $filename;
        }

        // Werk de details van de film bij
        $movie->title = $data['title'];
        $movie->director = $data['director'];
        $movie->description = $data['description'];

        $movie->save();

        // Werk de aan de film gekoppelde tags bij
        $tags = $request->input('tags');
        $movie->tags()->sync($tags);

        return redirect()->route('user.movies');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        if (Auth::user()->id !== $movie->user_id) {
            // Als de huidige gebruiker geen toestemming heeft, doorverwijzen naar de lijst van films van de gebruiker.
            return redirect()->route('user.movies');
        }

        // Verwijder de gekoppelde tags handmatig
        $movie->tags()->detach();

        // Verwijder de film uit de opslag.
        $movie->delete();

        // Doorverwijzen naar de lijst van films van de gebruiker.
        return redirect()->route('user.movies');
    }


    /**
     * Validate the data before creating or updating a movie.
     */
    protected function validator(array $data)
    {
        // Haal alle tags op uit de database.
        $tags = Tag::all();

        // Definieer de validatieregels voor verschillende velden.
        $validationArray = [
            'title' => ['required', 'string', 'max:255'],
            'director' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'image' => ['mimes:jpg,jpeg,png,gif,svg,webp', 'max:10000']
        ];

        // Voeg validatieregels toe voor elk tag-genre.
        foreach ($tags as $tag) {
            $validationArray[$tag->genre] = ['numeric'];
        }
        // Maak een Validator-object met de gegeven gegevens en validatie-array.
        return Validator::make($data, $validationArray);
    }
}
