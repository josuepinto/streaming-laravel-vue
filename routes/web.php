<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\SeriesListController;
use App\Http\Controllers\MovieListController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EpisodeController;
use App\Models\Movie;
use App\Models\Serie;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🔐 Autenticación
//Route::get('/', fn() => view('user/signup'))->name('inici');
Route::get('/register', fn() => view('user.signup'))->name('inici');

Route::post('/register', [UserController::class, 'register'])->name('register');
Route::get('/login', fn() => view('user/login'))->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', function () {
    Session::flush();
    return redirect('/login')->with('success', 'Logged out successfully!');
})->name('logout');

// 🏠 Home con buscador (películas y series)
/*Route::get('/home', function (Request $request) {
    if (!Session::has('user_id')) {
        return redirect('/login')->with('error', 'You need to login to access this page');
    }

    $userName = Session::get('user_name');
    $search = $request->input('search');

    $movies = $search ? Movie::where('title', 'like', "%{$search}%")->get() : Movie::all();
    $series = $search ? Serie::where('name', 'like', "%{$search}%")->get() : Serie::all();

    return view('home', compact('movies', 'series', 'userName'));
})->name('home');*/

// 🎬 Películas
Route::get('/films', [MovieListController::class, 'showList'])->name('movieList');
Route::get('/watch/{movie}', [MovieListController::class, 'show'])->name('watch');

// ❤️ Favoritos
Route::get('/favourite', [MovieListController::class, 'showFavourites']);
Route::get('/favourite/add/{id}', [MovieListController::class, 'addToFavourite'])->name('favourite.add');

// 💳 Suscripción
Route::get('/subs', fn() => view('user.subscription'));
Route::post('/select-plan', [MovieListController::class, 'selectPlan'])->name('select.plan');

// Recomendaciones
Route::get('/recomends', [MovieListController::class, 'showActionMovies'])->name('recomends');

// ==============================
// 🔧 RUTAS ADMIN
// ==============================

// 🎛 Panel de control principal (películas y series)
Route::get('/admin/panel', function () {
    $movies = Movie::all();
    $series = Serie::all();
    return view('admin.panel', compact('movies', 'series'));
})->name('adminPanel');

// ----------------------
// 🎞️ Películas (admin)
// ----------------------
Route::get('/admin/addMovie', fn() => view('admin.addMovie'))->name('addMovie');
Route::post('/admin/addMovie', [MovieListController::class, 'store'])->name('store');
Route::get('/admin/editMovie/{id}', [MovieListController::class, 'edit'])->name('editMovie');
Route::put('/admin/updateMovie/{id}', [MovieListController::class, 'update'])->name('updateMovie');
Route::delete('/admin/deleteMovie/{id}', [MovieListController::class, 'borrar'])->name('deleteMovie');

// ----------------------
// 📺 Series (admin)
// ----------------------
Route::get('/admin/addSerie', [SeriesListController::class, 'create'])->name('series.create');
Route::post('/admin/storeSerie', [SeriesListController::class, 'store'])->name('series.store');

// ✅ Vista pública de detalles de una serie
Route::get('/seriesList/{id}', [SeriesListController::class, 'show'])->name('series.show');

// ✅ Panel de series con buscador y acciones
Route::get('/admin/seriesPanel', [SeriesListController::class, 'seriesPanel'])->name('admin.seriesPanel');

// ✅ Editar, actualizar y eliminar series
Route::get('/admin/series/edit/{id}', [SeriesListController::class, 'edit'])->name('series.edit');
Route::put('/admin/series/update/{id}', [SeriesListController::class, 'update'])->name('series.update');
Route::delete('/admin/series/delete/{id}', [SeriesListController::class, 'destroy'])->name('series.destroy');

// ✅ Ver episodios por serie en modo administrador
Route::get('/admin/episodesPanel/{serieId}', [EpisodeController::class, 'episodesPanel'])->name('admin.episodesPanel');

// ✅ Agregar nuevo episodio (con selección de serie y temporada)
Route::match(['get', 'post'], '/admin/addEpisode', [EpisodeController::class, 'create'])->name('addEpisode');
Route::post('/episodes', [EpisodeController::class, 'store'])->name('episodes.store');

// ✅ Editar y eliminar episodios
Route::get('/admin/episodes/edit/{id}', [EpisodeController::class, 'edit'])->name('episodes.edit');
Route::put('/admin/episodes/update/{id}', [EpisodeController::class, 'update'])->name('episodes.update');
Route::delete('/admin/episodes/delete/{id}', [EpisodeController::class, 'destroy'])->name('episodes.destroy');

// ----------------------
// 🌐 Series públicas
// ----------------------
Route::get('/series', [SeriesListController::class, 'showList'])->name('listaSeries');





//-------------
Route::get('/api/check-session', function () {
    return response()->json(['loggedIn' => Session::has('user_id')]);
});

Route::get('/api/novelties', function () {
    $userId = Session::get('user_id');
    $lastLogin = Session::get('last_login_before'); // ⬅️ NUEVO

    if (!$userId) {
        return response()->json(['error' => 'Not authenticated'], 403);
    }

    if (!$lastLogin) {
        return response()->json([]); // nada que comparar
    }

    return \App\Models\Movie::where('created_at', '>', $lastLogin)
                ->orderBy('created_at', 'desc')
                ->get();
});


//  RUTAS PARA VUE
Route::get('/{any}', function () {
    return view('vue');
})->where('any', '.*');
