<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Http\Requests\MovieRequest;

class MovieListController extends Controller
{
    public function store(MovieRequest $request)
    {
        $movie = new Movie();
        $movie->title = $request->input('title');
        $movie->description = $request->input('description');
        $movie->genre = $request->input('genre');
        $movie->year = $request->input('year');
        $movie->video_url = $request->input('video_url');
        $image = $request->file('image');
        // Genera un nombre único para la imagen basado en la marca de tiempo
        $imageName = time() . '_' . $image->getClientOriginalName();
        // Guarda la imagen en el directorio 'public/image'
        $image->move(public_path('image'), $imageName);
        $movie->image = $imageName;

        $movie->save();

        return redirect()->route('movieList');
    }

    public function showList() {
        // reterive the list from db
        $moviesList = Movie::all();
        return view('moviesList', ['moviesList'=>$moviesList]);
    }
}
