<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeriesListController;
use App\Http\Controllers\MovieListController;
use App\Models\Movie;


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
    return view('welcome');
});

// after logging the user will go to the home page of app
// this is main page containing all info e:g films, series etc
Route::get('/home', function () {
    $movies = Movie::all();
    return view('home', compact('movies'));
});

// this route will display the list of films
Route::get('/films', [MovieListController::class, 'showList'])->name('movieList');



// Route for series list 
Route::get('/series', [SeriesListController::class, 'showList'])->name('listaSeries');


// Admin routes start below
Route::get('/admin/panel', function () {
    return view('admin.panel');
});

Route::get('/admin/addMovie', function () {
    return view('admin.addMovie');
});

Route::post('/admin/addMovie', [MovieListController::class, 'store'])->name('store');
