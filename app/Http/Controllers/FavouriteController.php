<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Movie;
use App\Models\Serie;
use Illuminate\Support\Facades\Session;

class FavouriteController extends Controller
{
    public function index()
    {
        if (! Session::has('user_id')) {
            return redirect('/login')->with('error', 'Please log in to view your favourites.');
        }

        $userId = Session::get('user_id');

        $favourites = Favourite::with('favouritable')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        return view('user.favourite', compact('favourites'));
    }

    public function addMovie($movieId)
    {
        if (! Session::has('user_id')) {
            return redirect('/login')->with('error', 'Please log in to add favourites.');
        }

        $movie = Movie::findOrFail($movieId);
        $userId = Session::get('user_id');

        Favourite::firstOrCreate([
            'user_id' => $userId,
            'favouritable_id' => $movie->id,
            'favouritable_type' => Movie::class,
        ]);

        return redirect()->back()->with('success', 'Movie added to favourites!');
    }

    public function addSerie($serieId)
    {
        if (! Session::has('user_id')) {
            return redirect('/login')->with('error', 'Please log in to add favourites.');
        }

        $serie = Serie::findOrFail($serieId);
        $userId = Session::get('user_id');

        Favourite::firstOrCreate([
            'user_id' => $userId,
            'favouritable_id' => $serie->id,
            'favouritable_type' => Serie::class,
        ]);

        return redirect()->back()->with('success', 'Series added to favourites!');
    }

    public function destroy($id)
    {
        if (! Session::has('user_id')) {
            return redirect('/login')->with('error', 'Please log in to manage favourites.');
        }

        $userId = Session::get('user_id');

        $favourite = Favourite::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();

        $favourite->delete();

        return redirect()->back()->with('success', 'Favourite removed successfully.');
    }
}
