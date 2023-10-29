<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
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
        return view('user.home');
    }

    public function movies()
    {
        // Haal alle films op die toebehoren aan de huidige gebruiker en sorteer ze op aanmaakdatum.
        $movies = Movie::all()->where('user_id', '=', \Auth::user()->id)->sortByDesc('created_at');

        // Toon de lijst van films op de pagina voor gebruikersfilms.
        return view('user.movies', compact('movies'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Controleer of de huidige gebruiker de eigenaar is van het bewerkingsformulier.
        if (Auth::user()->id !== $user->id) {
            // Als de huidige gebruiker niet de eigenaar is, doorverwijzen naar de gebruikerspagina.
            return redirect()->route('user.index');
        }

        // Als de huidige gebruiker de eigenaar is, toon het bewerkingsformulier voor de gebruiker.
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Valideer de gegevens in het verzoek met de juiste validatieregels.
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profile-picture' => 'sometimes|mimes:jpg,jpeg,png,gif,svg,webp|max:10000',
        ]);

        // Controleer of er een nieuw profielfoto-bestand is geüpload.
        if ($request->file('profile-picture') !== null) {
            $image = $request->file('profile-picture');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/users'), $filename);

            // Verwijder de oude profielfoto als er een nieuwe is geüpload.
            File::delete(public_path('img/users/' . $user->profile_picture));

            // Bijwerken van het profielfoto-veld in de database.
            $user->profile_picture = $filename;
        }

        // Bijwerken van de gebruikersnaam en e-mail in de database.
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Opslaan van de bijgewerkte gegevens van de gebruiker.
        $user->save();

        // Doorverwijzen naar de gebruikerspagina.
        return redirect()->route('user.index');
    }
}
