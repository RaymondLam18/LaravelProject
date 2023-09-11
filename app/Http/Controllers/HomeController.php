<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $text = 'welcome to this page';
        return view('home', compact('text'));
    }
}
