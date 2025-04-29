<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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
Route::get('/home', function (Request $request) {
    if (!Session::has('user_id')) {
        return redirect('/login')->with('error', 'You need to login to access this page');
    }

    $userName = Session::get('user_name');

    $search = $request->input('search');

    if ($search) {
        $movies = Movie::where('title', 'like', "%{$search}%")->get();
        $series = Serie::where('name', 'like', "%{$search}%")->get();
    } else {
        $movies = Movie::all();
        $series = Serie::all();
    }

    return view('home', compact('movies', 'series', 'userName'));
})->name('home');

// this route will display the list of films
Route::get('/films', [MovieListController::class, 'showList'])->name('movieList');

//Route::get('/films/{id}', [MovieListController::class, 'show'])->name('showMovie');



// Route for series list 
Route::get('/series', [SeriesListController::class, 'showList'])->name('listaSeries');

// Route for video playing
Route::get('/watch/{movie}', [MovieListController::class, 'show'])->name('watch');

// Route for favourte the movie/ or add in the list of movie
Route::get('/favourite', [MovieListController::class, 'showFavourites']);

Route::get('/favourite/add/{id}', [MovieListController::class, 'addToFavourite'])->name('favourite.add');

Route::get('/subs', function () {
    return view('user.subscription');
});

Route::post('/select-plan', [MovieListController::class, 'selectPlan'])->name('select.plan');

// route for logout with delete from session
Route::get('/logout', function () {
    Session::flush();
    return redirect('/login')->with('success', 'Logged out successfully!');
})->name('logout');

// Admin routes start below
Route::get('/admin/panel', function () {
    $movies = Movie::all();
    $series = Serie::all();
    return view('admin.panel', compact('movies', 'series'));
})->name('adminPanel');

Route::get('/admin/addMovie', function () {
    return view('admin.addMovie');
})->name('addMovie');

Route::post('/admin/addMovie', [MovieListController::class, 'store'])->name('store');

// route for DISPLAYING the form for updating the movie
Route::get('/admin/editMovie/{id}', [MovieListController::class, 'edit'])->name('editMovie');

// handle the form for updating the movie
Route::put('/admin/updateMovie/{id}', [MovieListController::class, 'update'])->name('updateMovie');

// route for deleting the movie
Route::delete('/admin/deleteMovie/{id}', [MovieListController::class, 'borrar'])->name('deleteMovie');

Route::match(['get', 'post'], '/admin/addEpisode', [EpisodeController::class, 'create'])->name('addEpisode');

Route::post('/episodes', [EpisodeController::class, 'store'])->name('episodes.store');


// Ruta para el formulario de agregar una serie
Route::get('/admin/addSerie', [SeriesListController::class, 'create'])->name('series.create');

// Ruta para almacenar la serie
Route::post('/admin/storeSerie', [SeriesListController::class, 'store'])->name('series.store');

Route::get('/seriesList/{id}', [SeriesListController::class, 'show'])->name('series.show');

