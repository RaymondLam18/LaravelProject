<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
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
Route::get('/about', [AboutController::class, 'index'])->name('about');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::patch('/movies/status/{movie}', [MovieController::class, 'status'])->name('movies.status');

Route::get('/movies/search', [MovieController::class, 'find'])->name('movies.search');

Route::resource('movies', MovieController::class);

Route::get('movies/details/{id}', [MovieController::class, 'details'])->name('movies.details');

Route::get('/user/movies', [ProfileController::class, 'movies'])->name('user.movies');

Route::post('/comments/store{movie}', [CommentController::class, 'store'])->name('comments.store');

Route::resource('user', ProfileController::class);

Route::resource('tags', TagController::class);

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin', [AdminController::class, 'index']);
});
