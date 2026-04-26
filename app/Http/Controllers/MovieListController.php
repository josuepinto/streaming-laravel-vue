<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieRequest;
use App\Models\Favourite;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MovieListController extends Controller
{
    public function store(MovieRequest $request)
    {
        $movie = new Movie();
        $movie->title = $request->input('title');
        $movie->description = $request->input('description');
        $movie->actor = $request->input('actor');
        $movie->director = $request->input('director');
        $movie->genre = $request->input('genre');
        $movie->year = $request->input('year');
        $movie->video_url = $request->input('video_url');

        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('image'), $imageName);
        $movie->image = 'image/' . $imageName;

        $movie->save();

        return redirect()->back()->with('success', 'Película añadida con éxito');
    }

    public function showList()
    {
        if (! Session::has('user_id')) {
            return redirect('/login')->with('error', 'You need to login to access this page');
        }

        $userId = Session::get('user_id');

        $moviesList = Movie::all();

        $movieFavouriteIds = Favourite::where('user_id', $userId)
            ->where('favouritable_type', Movie::class)
            ->pluck('id', 'favouritable_id')
            ->toArray();

        return view('moviesList', [
            'moviesList' => $moviesList,
            'movieFavouriteIds' => $movieFavouriteIds,
        ]);
    }

    public function show($id)
    {
        if (! Session::has('user_id')) {
            return redirect('/login')->with('error', 'You need to login to access this page');
        }

        $movie = Movie::findOrFail($id);
        $userId = Session::get('user_id');

        $movieFavouriteId = Favourite::where('user_id', $userId)
            ->where('favouritable_type', Movie::class)
            ->where('favouritable_id', $movie->id)
            ->value('id');

        return view('user.watch', [
            'movie' => $movie,
            'movieFavouriteId' => $movieFavouriteId,
        ]);
    }

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

        return redirect()->back()->with('message', 'You have successfully selected the ' . $selectedPlan . ' plan.');
    }

    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        return view('admin.update', compact('movie'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:movies,title,' . $id,
            'description' => 'required|string|max:1000',
            'actor' => 'nullable|string|max:255',
            'director' => 'nullable|string|max:255',
            'genre' => 'nullable|string|max:255',
            'year' => 'nullable|numeric',
            'video_url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.unique' => 'A movie with this title already exists.',
        ]);


        $movie = Movie::findOrFail($id);

        $movie->title = $request->title;
        $movie->description = $request->description;
        $movie->actor = $request->actor;
        $movie->director = $request->director;
        $movie->genre = $request->genre;
        $movie->year = $request->year;
        $movie->video_url = $request->video_url;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image'), $imageName);
            $movie->image = 'image/' . $imageName;
        }

        $movie->save();

        return redirect()->back()->with('success', 'Movie updated successfully!');
    }

    public function borrar($id)
    {
        $movie = Movie::findOrFail($id);
        $movie->delete();

        return redirect()->back()->with('success', 'Movie deleted successfully!');
    }

    public function showActionMovies()
    {
        $actionMovies = Movie::where('genre', 'Action')->get();
        return view('user.recomended', ['actionMovies' => $actionMovies]);
    }
}
