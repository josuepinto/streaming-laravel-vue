<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeriesListController;
use App\Http\Controllers\MovieListController;
use App\Http\Controllers\UserController;
use App\Models\Movie;
use App\Models\Serie;
use App\Models\Episode;
use App\Http\Controllers\EpisodeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('user/signup');
})->name('inici');

//route for processing the signup form 
Route::post('/register', [UserController::class, 'register'])->name('register');

Route::get('/login', function () {
    return view('user/login');
})->name('login');

// route for processing the login form
Route::post('/login', [UserController::class, 'login']);

// after logging the user will go to the home page of app
// this is main page containing all info e:g films, series etc
Route::get('/home', function () {
    $movies = Movie::all();
    return view('home', compact('movies'));
})->name('home');

// this route will display the list of films
Route::get('/films', [MovieListController::class, 'showList'])->name('movieList');



// Route for series list 
Route::get('/series', [SeriesListController::class, 'showList'])->name('listaSeries');

// Route for video playing
Route::get('/watch/{movie}', [MovieListController::class, 'showVideo'])->name('watch');

// Admin routes start below
Route::get('/admin/panel', function () {
    return view('admin.panel');
});

Route::get('/admin/addMovie', function () {
    return view('admin.addMovie');
})->name('addMovie');

Route::post('/admin/addMovie', [MovieListController::class, 'store'])->name('store');

Route::get('/episodes/create', [EpisodeController::class, 'create'])->name('episodes.create');
Route::post('/episodes', [EpisodeController::class, 'store'])->name('episodes.store');