<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index() {
        $text = 'welcome to about';
        return view('about', compact('text'));
    }
}
