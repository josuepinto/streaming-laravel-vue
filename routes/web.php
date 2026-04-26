<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\MovieListController;
use App\Http\Controllers\SeriesListController;
use App\Http\Controllers\UserController;
use App\Models\Movie;
use App\Models\Serie;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Auth
Route::get('/', fn() => view('user/signup'))->name('inici');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::get('/login', fn() => view('user/login'))->name('login');
Route::post('/login', [UserController::class, 'login']);

Route::get('/logout', function (Request $request) {
    Session::flush();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')->with('success', 'Logged out successfully!');
})->name('logout');

// Home
Route::get('/home', function (Request $request) {
    if (! Session::has('user_id')) {
        return redirect('/login')->with('error', 'You need to login to access this page');
    }

    $userId = Session::get('user_id');
    $userName = Session::get('user_name');
    $search = $request->input('search');

    $movies = $search
        ? Movie::where('title', 'like', "%{$search}%")->get()
        : Movie::all();

    $series = $search
        ? Serie::where('name', 'like', "%{$search}%")->get()
        : Serie::all();

    $movieFavouriteIds = \App\Models\Favourite::where('user_id', $userId)
        ->where('favouritable_type', Movie::class)
        ->pluck('id', 'favouritable_id')
        ->toArray();

    $serieFavouriteIds = \App\Models\Favourite::where('user_id', $userId)
        ->where('favouritable_type', Serie::class)
        ->pluck('id', 'favouritable_id')
        ->toArray();

    return view('home', compact(
        'movies',
        'series',
        'userName',
        'movieFavouriteIds',
        'serieFavouriteIds'
    ));
})->name('home');


// Public movies
Route::get('/films', [MovieListController::class, 'showList'])->name('movieList');
Route::get('/watch/{movie}', [MovieListController::class, 'show'])->name('watch');

// Favourites
Route::get('/favourite', [FavouriteController::class, 'index'])->name('favourite.index');
Route::get('/favourite/movie/{id}', [FavouriteController::class, 'addMovie'])->name('favourite.movie.add');
Route::get('/favourite/serie/{id}', [FavouriteController::class, 'addSerie'])->name('favourite.serie.add');
Route::delete('/favourite/{id}', [FavouriteController::class, 'destroy'])->name('favourite.destroy');


// Subscription
Route::get('/subs', fn() => view('user.subscription'));
Route::post('/select-plan', [MovieListController::class, 'selectPlan'])->name('select.plan');

// Recommendations
Route::get('/recomends', [MovieListController::class, 'showActionMovies'])->name('recomends');

// Public series
Route::get('/seriesList/{id}', [SeriesListController::class, 'show'])->name('series.show');
Route::get('/series', [SeriesListController::class, 'showList'])->name('listaSeries');

// Admin routes
Route::middleware('admin')->group(function () {
    Route::get('/admin/panel', function () {
        $movies = Movie::all();
        $series = Serie::all();

        return view('admin.panel', compact('movies', 'series'));
    })->name('adminPanel');

    // Movies admin
    Route::get('/admin/addMovie', fn() => view('admin.addMovie'))->name('addMovie');
    Route::post('/admin/addMovie', [MovieListController::class, 'store'])->name('store');
    Route::get('/admin/editMovie/{id}', [MovieListController::class, 'edit'])->name('editMovie');
    Route::put('/admin/updateMovie/{id}', [MovieListController::class, 'update'])->name('updateMovie');
    Route::delete('/admin/deleteMovie/{id}', [MovieListController::class, 'borrar'])->name('deleteMovie');

    // Series admin
    Route::get('/admin/addSerie', [SeriesListController::class, 'create'])->name('series.create');
    Route::post('/admin/storeSerie', [SeriesListController::class, 'store'])->name('series.store');
    Route::get('/admin/seriesPanel', [SeriesListController::class, 'seriesPanel'])->name('admin.seriesPanel');
    Route::get('/admin/series/edit/{id}', [SeriesListController::class, 'edit'])->name('series.edit');
    Route::put('/admin/series/update/{id}', [SeriesListController::class, 'update'])->name('series.update');
    Route::delete('/admin/series/delete/{id}', [SeriesListController::class, 'destroy'])->name('series.destroy');

    // Episodes admin
    Route::get('/admin/episodesPanel/{serieId}', [EpisodeController::class, 'episodesPanel'])->name('admin.episodesPanel');
    Route::match(['get', 'post'], '/admin/addEpisode', [EpisodeController::class, 'create'])->name('addEpisode');
    Route::post('/episodes', [EpisodeController::class, 'store'])->name('episodes.store');
    Route::get('/admin/episodes/edit/{id}', [EpisodeController::class, 'edit'])->name('episodes.edit');
    Route::put('/admin/episodes/update/{id}', [EpisodeController::class, 'update'])->name('episodes.update');
    Route::delete('/admin/episodes/delete/{id}', [EpisodeController::class, 'destroy'])->name('episodes.destroy');
});
