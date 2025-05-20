<?php

// ✅ Importamos todas las clases y controladores necesarios
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
| 🌐 Web Routes (Blade + Vue)
|--------------------------------------------------------------------------
| Este archivo gestiona todas las rutas de la parte pública (Blade y Vue).
| Aquí se combinan vistas Blade para administración y login con API y
| redirección completa a Vue para Single Page Application.
|
| ✳️ Vue se carga con la última ruta: Route::get('/{any}')
*/

// -----------------------------
// 🔐 AUTENTICACIÓN DE USUARIOS
// -----------------------------

// Página de registro de usuario (Blade)
Route::get('/register', fn() => view('user.signup'))->name('inici');

// Proceso POST de registro
Route::post('/register', [UserController::class, 'register'])->name('register');

// Página de login de usuario (Blade)
Route::get('/login', fn() => view('user.login'))->name('login');

// Proceso POST de login
Route::post('/login', [UserController::class, 'login']);

// 🔓 Cierre de sesión
Route::get('/logout', function () {
    Session::put('last_login_before', Session::get('last_login')); // guardamos login anterior
    Session::flush(); // limpiamos la sesión
    return redirect('/login')->with('success', 'Logged out successfully!');
})->name('logout');

// --------------------------------------
// 🎬 PÁGINAS ADMIN DE PELÍCULAS Y SERIES
// --------------------------------------

// Panel de control principal (admin)
Route::get('/admin/panel', function () {
    $movies = Movie::all();
    $series = Serie::all();
    return view('admin.panel', compact('movies', 'series'));
})->name('adminPanel');

// CRUD para películas (formulario Blade)
Route::get('/admin/addMovie', fn() => view('admin.addMovie'))->name('addMovie');
Route::post('/admin/addMovie', [MovieListController::class, 'store'])->name('store');
Route::get('/admin/editMovie/{id}', [MovieListController::class, 'edit'])->name('editMovie');
Route::put('/admin/updateMovie/{id}', [MovieListController::class, 'update'])->name('updateMovie');
Route::delete('/admin/deleteMovie/{id}', [MovieListController::class, 'borrar'])->name('deleteMovie');

// CRUD para series
Route::get('/admin/addSerie', [SeriesListController::class, 'create'])->name('series.create');
Route::post('/admin/storeSerie', [SeriesListController::class, 'store'])->name('series.store');

// Panel para gestionar series
Route::get('/admin/seriesPanel', [SeriesListController::class, 'seriesPanel'])->name('admin.seriesPanel');

// Editar / actualizar series
Route::get('/admin/series/edit/{id}', [SeriesListController::class, 'edit'])->name('series.edit');
Route::put('/admin/series/update/{id}', [SeriesListController::class, 'update'])->name('series.update');
Route::delete('/admin/series/delete/{id}', [SeriesListController::class, 'destroy'])->name('series.destroy');

// Episodios (asociados a series)
Route::get('/admin/episodesPanel/{serieId}', [EpisodeController::class, 'episodesPanel'])->name('admin.episodesPanel');
Route::match(['get', 'post'], '/admin/addEpisode', [EpisodeController::class, 'create'])->name('addEpisode');
Route::post('/episodes', [EpisodeController::class, 'store'])->name('episodes.store');
Route::get('/admin/episodes/edit/{id}', [EpisodeController::class, 'edit'])->name('episodes.edit');
Route::put('/admin/episodes/update/{id}', [EpisodeController::class, 'update'])->name('episodes.update');
Route::delete('/admin/episodes/delete/{id}', [EpisodeController::class, 'destroy'])->name('episodes.destroy');

// -----------------------------
// 🌍 Series públicas (vista Vue)
// -----------------------------
Route::get('/seriesList/{id}', [SeriesListController::class, 'show'])->name('series.show');
Route::get('/series', [SeriesListController::class, 'showList'])->name('listaSeries');

// --------------------------------------------
// ❤️ FAVORITOS, RECOMENDACIONES Y SUSCRIPCIÓN
// --------------------------------------------
Route::get('/favourite', [MovieListController::class, 'showFavourites']);
Route::get('/favourite/add/{id}', [MovieListController::class, 'addToFavourite'])->name('favourite.add');
Route::get('/subs', fn() => view('user.subscription'));
Route::post('/select-plan', [MovieListController::class, 'selectPlan'])->name('select.plan');
Route::get('/recomends', [MovieListController::class, 'showActionMovies'])->name('recomends');

// -----------------------------
// 🧠 API para verificar sesión
// Usada en App.vue → criterio 04_01
// -----------------------------
Route::get('/api/check-session', function () {
    return response()->json(['loggedIn' => Session::has('user_id')]);
});

// ----------------------------------------------------
// 🆕 04_01 — NOVEDADES DESDE ÚLTIMO LOGIN DEL USUARIO
// Este endpoint es llamado por Vue y Service Worker
// ----------------------------------------------------
Route::get('/api/novelties', function () {
    $userId = Session::get('user_id');
    $lastLogin = Session::get('last_login_before'); // fecha guardada al hacer logout

    if (!$userId) {
        return response()->json(['error' => 'Not authenticated'], 403);
    }

    if (!$lastLogin) {
        return response()->json([]); // primera vez → sin novedades
    }

    return \App\Models\Movie::where('created_at', '>', $lastLogin)
        ->orderBy('created_at', 'desc')
        ->get();
});

// =====================================================================
// ✅ RUTA CRÍTICA PARA VUE SPA (vue.blade.php) → última de todas
// Esta ruta captura cualquier petición no capturada antes ("/", "/movie/3", etc.)
// Muestra la plantilla SPA Vue en vue.blade.php
// =====================================================================
Route::get('/{any}', function () {
    return view('vue'); // blade que carga <div id="app">
})->where('any', '.*'); // cualquier ruta que no empiece con /api o /admin
