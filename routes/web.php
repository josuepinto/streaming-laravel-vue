<?php

use Illuminate\Support\Facades\Route;
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

// this route will only display latest films only
Route::get('/films', function () {
    return view('filmList');
});

// After clicking in one film the route will change and take the id/name of that film
// this route will responsible to show the film with their details
Route::get('/films/SpiderMan', function () {
    return view('spiderMan');
});

// Route for displaying the series lists
//Route::get('/series', function () {
  //  return view('seriesList');
//});

// Route for series list 
Route::get('/series', [SeriesListController::class, 'showList'])->name('listaSeries');

// After click in one series the routes will be change
// and if sereies have episodes the user if click in any other episode
// the route will change also
Route::get('/series/name/episode1', function () {
    return view('Berlin');
});

// Route to see myList/Favourite
Route::get('/myList', function () {
    return view('favouriteList');
});
