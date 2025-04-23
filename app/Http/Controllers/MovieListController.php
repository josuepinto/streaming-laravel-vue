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

        return redirect()->back()->with('success', 'Película añadida con éxito');

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

    // for updating the movie
    public function edit($id) {
        $movie = Movie::findOrFail($id);
        return view('admin.update', compact('movie'));
    }

    // for update and save changes to db
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
    
        // Update image only if new image uploaded
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('image', 'public');
            $movie->image = 'image/' . $imagePath;
        }
    
        $movie->save();
    
        return redirect()->back()->with('success', 'Movie updated successfully!');
    }

    // for deleting the movie
    public function borrar($id) {
        $movie = Movie::findOrFail($id);
        $movie->delete();
        return redirect()->back()->with('success', 'Movie deleted successfully!');
    }
}
