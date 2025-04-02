<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Http\Requests\MovieRequest;

class MovieListController extends Controller
{
    // this is method to store the film into db coming from the admin form
    public function store(MovieRequest $request)
    {

        // Validación de los datos
        $request->validate([
            'title' => 'required|string|max:255', // El título es obligatorio, debe ser una cadena y no superar los 255 caracteres
            'description' => 'required|string', // La descripción es obligatoria y debe ser una cadena
            'genre' => 'required|string', // El género es obligatorio y debe ser una cadena
            'year' => 'required|integer|digits:4', // El año es obligatorio, debe ser un número entero y de 4 dígitos
            'video_url' => 'required|url', // La URL del video es obligatoria y debe ser una URL válida
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // La imagen es obligatoria, debe ser una imagen y no superar 2MB
        ]);


        // Guardar la serie en la base de datos

        $movie = new Movie();
        $movie->title = $request->input('title');
        $movie->description = $request->input('description');
        $movie->actor = $request->input('actor');
        $movie->director = $request->input('director');
        $movie->genre = $request->input('genre');
        $movie->year = $request->input('year');
        $movie->video_url = $request->input('video_url');
        $image = $request->file('image');
        // Genera un nombre único para la imagen basado en la marca de tiempo
        $imageName = time() . '_' . $image->getClientOriginalName();
        // Guarda la imagen en el directorio 'public/image'
        $image->move(public_path('image'), $imageName);
        $movie->image = 'image/' . $imageName;// Almacenar solo el nombre de la imagen en la base de datos

        $movie->save();

        return redirect()->route('movieList')->with('success', 'Película añadida con éxito');

    }

    public function showList() {
        // reterive the list from db
        $moviesList = Movie::all();
        return view('moviesList', ['moviesList'=>$moviesList]);
    }

    public function show($id)
    {
        // Obtener la película por ID
        $movie = Movie::findOrFail($id);
        
        // Pasar la película a la vista 'showMovie'
        return view('user.watch', ['movie' => $movie]);
    }
}
