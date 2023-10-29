<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Show the application.
     *
     */
    public function index() {
        return view('about');
    }
}
