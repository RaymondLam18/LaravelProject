<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Pas de 'auth'-middleware toe op alle methoden.
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Voer de administratiefunctie uit om te controleren of de gebruiker een beheerder is.
        $this->admin();

        // Haal alle tags op uit de database.
        $tags = Tag::all();

        // Geef de lijst van tags weer op de beheerderspagina.
        return view('admin.tags.home', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Voer de administratiefunctie uit om te controleren of de gebruiker een beheerder is.
        $this->admin();

        // Toon het formulier voor het maken van een nieuwe tag op de beheerderspagina.
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Voer de administratiefunctie uit om te controleren of de gebruiker een beheerder is.
        $this->admin();

        // Valideer de gegevens met behulp van de validator.
        $data = $this->validator($request->all())->validate();

        // Maak een nieuwe tag en sla deze op in de database.
        Tag::create([
            'genre' => $data['genre']
        ]);

        // Doorverwijzen naar de lijst van tags op de beheerderspagina.
        return redirect()->route('tags.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        // Voer de administratiefunctie uit om te controleren of de gebruiker een beheerder is.
        $this->admin();

        // Verwijder de tag uit de opslag.
        $tag->delete();

        // Doorverwijzen naar de lijst van tags op de beheerderspagina.
        return redirect()->route('tags.index');
    }

    /**
     * Define validation rules for creating or updating a tag.
     */
    protected function validator(array $data)
    {
        // Definieer validatieregels met behulp van de Validator-functie.
        return Validator::make($data, [
            'genre' => ['required', 'string', 'max:25']
        ]);
    }

    /**
     * Verify that the current user is an administrator.
     * If not, refer to the films index.
     */
    protected function admin()
    {
        if (Auth::user()->id != 1) {
            // Als de huidige gebruiker geen beheerder is, doorverwijzen naar de films-index.
            return redirect()->route('movies.index');
        }
        // Doorverwijs naar de 'tags.index' route.
        return redirect()->route('tags.index');
    }

}
