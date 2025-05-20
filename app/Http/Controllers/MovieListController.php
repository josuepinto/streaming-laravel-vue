<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Movie;
use App\Models\Favourite;
use App\Http\Requests\MovieRequest;
use Illuminate\Support\Facades\File;

class MovieListController extends Controller
{
    // =============================================
    // 🎯 Método para guardar una nueva película
    // ✅ Se usa en el panel admin: Vista addMovie.blade.php
    // =============================================
    public function store(MovieRequest $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genre' => 'required|string',
            'year' => 'required|integer|digits:4',
            'video_url' => 'required|url',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $movie = new Movie();
        $movie->title = $request->input('title');
        $movie->description = $request->input('description');
        $movie->actor = $request->input('actor');
        $movie->director = $request->input('director');
        $movie->genre = $request->input('genre');
        $movie->year = $request->input('year');
        $movie->video_url = $request->input('video_url');

        // 🖼️ Guardamos imagen en public/image
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('image'), $imageName);
        $movie->image = 'image/' . $imageName;

        $movie->save();

        return redirect()->back()->with('success', 'Película añadida con éxito');
    }

    // =============================================
    // 🎬 Muestra listado de películas (Blade)
    // ⚠️ Solo usado en vista antigua: moviesList.blade.php
    // =============================================
    public function showList() {
        if (!Session::has('user_id')) {
            return redirect('/login')->with('error', 'You need to login to access this page');
        }

        $moviesList = Movie::all();
        return view('moviesList', ['moviesList'=>$moviesList]);
    }

    // =============================================
    // ▶️ Mostrar detalles de película en Blade
    // ⚠️ Solo usado en versión Blade, no en Vue
    // =============================================
    public function show($id)
    {
        $movie = Movie::findOrFail($id);
        return view('user.watch', ['movie' => $movie]);
    }

    // =============================================
    // ❤️ Añadir película a favoritos
    // =============================================
    public function addToFavourite($movieId)
    {
        if (!Favourite::where('movie_id', $movieId)->exists()) {
            Favourite::create([
                'movie_id' => $movieId
            ]);
        }

        return redirect('/favourite')->with('success', 'Movie added to favourites!');
    }

    public function showFavourites()
    {
        $favourites = Favourite::with('movie')->get();
        return view('user.favourite', compact('favourites'));
    }

    // =============================================
    // 💳 Guardar selección de plan de suscripción
    // =============================================
    public function selectPlan(Request $request)
    {
        $request->validate([
            'plan' => 'required',
            'cn' => 'required',
            'ed' => 'required',
            'cvv' => 'required',
        ], [
            'plan.required' => 'Please select plan before!',
            'cn.required' => 'Enter valid card number',
            'ed.required' => 'Provide expiry date of your card',
            'cvv.required' => 'Enter CVV number of 3 digits',
        ]);

        $selectedPlan = $request->plan;

        return redirect()->back()->with('message', 'You have successfully selected the ' .$selectedPlan . ' plan.');
    }

    // =============================================
    // ✏️ Mostrar película a editar (formulario admin)
    // =============================================
    public function edit($id) {
        $movie = Movie::findOrFail($id);
        return view('admin.update', compact('movie'));
    }

    // =============================================
    // 💾 Guardar cambios en la película
    // ✅ Relacionado con el criterio 05_01 de Vue
    // =============================================
    public function update(Request $request, $id) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'actor' => 'nullable|string|max:255',
            'director' => 'nullable|string|max:255',
            'genre' => 'nullable|string|max:255',
            'year' => 'nullable|numeric',
            'video_url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $movie = Movie::findOrFail($id);

        $movie->title = $request->title;
        $movie->description = $request->description;
        $movie->actor = $request->actor;
        $movie->director = $request->director;
        $movie->genre = $request->genre;
        $movie->year = $request->year;
        $movie->video_url = $request->video_url;

        // ✅ Solo actualiza imagen si se subió una nueva
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('image', 'public');
            $movie->image = 'image/' . $imagePath;
        }

        $movie->save();

        return redirect()->back()->with('success', 'Movie updated successfully!');
    }

    // =============================================
    // ❌ Eliminar película
    // =============================================
    public function borrar($id) {
        $movie = Movie::findOrFail($id);
        $movie->delete();
        return redirect()->back()->with('success', 'Movie deleted successfully!');
    }

    // =============================================
    // ⭐ Recomendaciones → solo género 'Action'
    // =============================================
    public function showActionMovies() {
        $actionMovies = Movie::where('genre', 'Action')->get();
        return view('user.recomended', ['actionMovies'=>$actionMovies]);
    }

    // =============================================
    // 🔁 API para Vue — devuelve películas paginadas
    // ✅ Criterio 03_01 y 06_01: Lista de películas
    // =============================================
    public function apiIndex(){
        return Movie::paginate(4); // se usa en Vue para paginación de MovieList
    }

    // =============================================
    // 📸 Devuelve las imágenes disponibles (por nombre)
    // ✅ Usado en Vue para editar películas sin romper ruta de imagen
    // =============================================
    public function getAvailableImages()
    {
        $images = File::files(public_path('image'));
        $imageNames = collect($images)->map(function ($file) {
            return 'image/' . $file->getFilename(); // ruta relativa usada en Vue
        });

        return response()->json($imageNames);
    }
}
