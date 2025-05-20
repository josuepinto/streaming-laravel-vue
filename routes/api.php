<?php

// ✅ Importaciones necesarias para controlar rutas y acceder a modelos y datos
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
| 📡 API Routes - Laravel
|--------------------------------------------------------------------------
| Aquí se registran todas las rutas de tipo API (JSON).
| Son utilizadas principalmente desde Vue mediante `fetch` o `axios`.
| Se comunican con Laravel para leer, actualizar o buscar datos.
|
| Estas rutas son esenciales para cumplir criterios como:
| 06_01, 07_01, 08_01 y también funcionalidades como edición o búsqueda.
*/

// ==================================================================================
// 🔍 06_01 — Ruta para buscar películas en Laravel desde Vue
// Se lanza desde Vue al hacer una búsqueda usando query string (?q=)
// ==================================================================================
Route::get('/movies/search', function (Request $request) {
    $query = $request->query('q'); // obtener el valor de búsqueda

    // Consultamos múltiples campos de la tabla de películas
    return DB::table('movies')
        ->where('title', 'like', "%{$query}%")
        ->orWhere('description', 'like', "%{$query}%")
        ->orWhere('genre', 'like', "%{$query}%")
        ->orWhere('actor', 'like', "%{$query}%")
        ->orWhere('director', 'like', "%{$query}%")
        ->get(); // Devuelve un array JSON de resultados
});


// ============================================
// 🔐 Ruta protegida para obtener info del user
// No se usa directamente en este proyecto Vue
// ============================================
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// ==================================================================================
// 📥 06_01 — Obtener películas paginadas (usado desde MovieList.vue)
// 📥 07_01 — También lo usa el Service Worker para cargar todas las películas
// ==================================================================================
Route::get('/movies', [MovieListController::class, 'apiIndex']); // devuelve JSON paginado

// ✅ Obtener detalles de una película (por ID), usado en MovieDetail y EditMovie
Route::get('/movies/{id}', function ($id) {
    return Movie::findOrFail($id); // busca y devuelve una película específica
});

// ✅ Obtener los datos de edición (similar al anterior pero más explícito)
Route::get('/movies/{id}/edit', function ($id) {
    return Movie::findOrFail($id);
});


// ==================================================================================
// ✏️ 05_01 — Actualizar película desde formulario de edición (EditMovie.vue)
// Método PUT para editar campos como título, género, imagen, etc.
// ==================================================================================
Route::put('/movies/{id}', function (Request $request, $id) {
    $movie = Movie::findOrFail($id); // buscamos la película por ID

    // Actualizamos campos desde los datos enviados por Vue
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

    return response()->json(['status' => 'success']); // Respuesta JSON
});


// ==================================================================================
// 📷 05_01 — Ruta para cargar lista de imágenes desde /public/image
// Vue la usa para mostrar un select con imágenes en EditMovie.vue
// ==================================================================================
Route::get('/images', function () {
    $files = File::files(public_path('image')); // Lee los archivos en /public/image
    return collect($files)->map(fn($file) => $file->getFilename()); // Solo nombres
});


// (🔁 Extra) Ruta adicional no usada directamente
// Devuelve todas las películas sin paginar. Puede usarse para debug o pruebas.
Route::get('/movies/all', function () {
    return \App\Models\Movie::all();
});
