<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', [App\Http\Controllers\AboutController::class, 'index'])->name('about');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/movie', [App\Http\Controllers\MovieController::class, 'index'])->name('movie');

Route::resource('movies', MovieController::class);

Route::get('/user/movies', [ProfileController::class, 'posts'])->name('user.movies');

Route::resource('user', ProfileController::class);
