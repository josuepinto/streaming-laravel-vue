<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SeriesListController extends Controller
{
    public function create()
    {
        return view('admin.addSerie');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:series,name',
            'desc' => 'required|string',
            'actor' => 'required|string',
            'director' => 'required|string',
            'image' => 'required|image',
            'video_url' => 'required|url',
            'num_episode' => 'required|integer',
        ], [
            'name.unique' => 'A series with this name already exists.',
        ]);


        $serie = new Serie();
        $serie->name = $request->name;
        $serie->desc = $request->desc;
        $serie->actor = $request->actor;
        $serie->director = $request->director;
        $serie->video_url = $request->video_url;
        $serie->num_episode = $request->num_episode;

        if ($request->hasFile('image')) {
            $serie->image = $request->file('image')->store('series_images', 'public');
        }

        $serie->save();

        return redirect()->route('series.create')->with('success', 'Serie añadida con éxito');
    }

    public function show($id, Request $request)
    {
        if (! Session::has('user_id')) {
            return redirect('/login')->with('error', 'You need to login to access this page');
        }

        $serie = Serie::with('episodes')->findOrFail($id);
        $seasonFilter = $request->query('season');
        $userId = Session::get('user_id');

        $episodes = $serie->episodes;

        if ($seasonFilter) {
            $episodes = $episodes->where('season', $seasonFilter);
        }

        $seasons = $serie->episodes->pluck('season')->unique()->sort();

        $serieFavouriteId = Favourite::where('user_id', $userId)
            ->where('favouritable_type', Serie::class)
            ->where('favouritable_id', $serie->id)
            ->value('id');

        return view('showSerie', compact(
            'serie',
            'episodes',
            'seasons',
            'seasonFilter',
            'serieFavouriteId'
        ));
    }

    public function showList()
    {
        if (! Session::has('user_id')) {
            return redirect('/login')->with('error', 'You need to login to access this page');
        }

        $userId = Session::get('user_id');

        $seriesList = Serie::all();

        $serieFavouriteIds = Favourite::where('user_id', $userId)
            ->where('favouritable_type', Serie::class)
            ->pluck('id', 'favouritable_id')
            ->toArray();

        return view('seriesList', [
            'seriesList' => $seriesList,
            'serieFavouriteIds' => $serieFavouriteIds,
        ]);
    }

    public function edit($id)
    {
        $serie = Serie::findOrFail($id);
        return view('admin.editSerie', compact('serie'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:series,name,' . $id,
            'desc' => 'required|string',
            'actor' => 'required|string',
            'director' => 'required|string',
            'video_url' => 'required|url',
            'num_episode' => 'required|integer',
            'image' => 'nullable|image|max:2048',
        ], [
            'name.unique' => 'A series with this name already exists.',
        ]);



        $serie = Serie::findOrFail($id);

        $serie->name = $request->name;
        $serie->desc = $request->desc;
        $serie->actor = $request->actor;
        $serie->director = $request->director;
        $serie->video_url = $request->video_url;
        $serie->num_episode = $request->num_episode;

        if ($request->hasFile('image')) {
            $serie->image = $request->file('image')->store('series_images', 'public');
        }

        $serie->save();

        return redirect()->route('admin.seriesPanel')->with('success', 'Serie actualizada con éxito.');
    }

    public function destroy($id)
    {
        $serie = Serie::findOrFail($id);
        $serie->delete();

        return redirect()->route('admin.seriesPanel')->with('success', 'Serie eliminada con éxito.');
    }

    public function seriesPanel(Request $request)
    {
        $search = $request->query('search');
        $seriesList = Serie::query();

        if ($search) {
            $seriesList->where('name', 'like', '%' . $search . '%');
        }

        $seriesList = $seriesList->get();

        return view('admin.seriesPanel', compact('seriesList'));
    }
}
