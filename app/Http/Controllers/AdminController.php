<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
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
        // Voer de administratiefunctie uit.
        $this->admin();

        // Doorverwijs naar de 'tags.index' route.
        return redirect()->route('tags.index');
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
