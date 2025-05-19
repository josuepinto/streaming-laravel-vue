<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieListController;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// 🔍 API para buscar películas por título
Route::get('/movies/search', function (Request $request) {
    $query = $request->query('q');

    return DB::table('movies')
        ->where('title', 'like', "%{$query}%")
        ->orWhere('description', 'like', "%{$query}%")
        ->orWhere('genre', 'like', "%{$query}%")
        ->orWhere('actor', 'like', "%{$query}%")
        ->orWhere('director', 'like', "%{$query}%")
        ->get();
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/movies', [MovieListController::class, 'apiIndex']);
Route::get('/movies/{id}', function ($id) {
    return Movie::findOrFail($id);
});
Route::get('/movies/{id}/edit', function ($id) {
    return Movie::findOrFail($id);
});

Route::put('/movies/{id}', function (Request $request, $id) {
    $movie = Movie::findOrFail($id);

    $movie->update([
        'title' => $request->title,
        'description' => $request->description,
        'actor' => $request->actor,
        'director' => $request->director,
        'genre' => $request->genre,
        'year' => $request->year,
        'image' => $request->image,
        'video_url' => $request->video_url
    ]);

    return response()->json(['status' => 'success']);
});

Route::get('/images', function () {
    $files = File::files(public_path('image'));
    return collect($files)->map(fn($file) => $file->getFilename());
});

// api.php
Route::get('/movies/all', function () {
    return \App\Models\Movie::all();
});
