<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Movie $movie) {
        $state = true;
        if ($movie->likes()->where('user_id', '=', Auth::id())->exists()) {
            $movie->likes()->where('user_id', '=', Auth::id())->delete();
            $state = false;
        } else {
            Like::create([
                'post_id' => $movie->id,
                'user_id' => Auth::id()
            ]);
        }
        return $state;
    }
}
