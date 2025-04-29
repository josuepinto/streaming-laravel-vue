<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Serie;

class SeriesListController extends Controller
{
    // Mostrar el formulario para agregar una serie
    public function create()
    {
        return view('admin.addSerie');
    }

    // Guardar una nueva serie
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
            'actor' => 'required|string',
            'director' => 'required|string',
            'image' => 'required|image',
            'video_url' => 'required|url',
            'num_episode' => 'required|integer'
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

    // Mostrar detalles de una serie con sus episodios
    public function show($id, Request $request)
    {
        $serie = Serie::with('episodes')->findOrFail($id);
        $seasonFilter = $request->query('season');

        $episodes = $serie->episodes;

        if ($seasonFilter) {
            $episodes = $episodes->where('season', $seasonFilter);
        }

        $seasons = $serie->episodes->pluck('season')->unique()->sort();

        return view('showSerie', compact('serie', 'episodes', 'seasons', 'seasonFilter'));
    }

    // Mostrar todas las series en listado de usuarios
    public function showList()
    {
        $seriesList = Serie::all();
        return view('seriesList', ['seriesList' => $seriesList]);
    }

    // Mostrar todas las series para administración
    public function adminPanel()
    {
        $series = Serie::all();
        return view('admin.seriesPanel', compact('series'));
    }

    // Mostrar formulario de edición de serie
    public function edit($id)
    {
        $serie = Serie::findOrFail($id);
        return view('admin.editSerie', compact('serie'));
    }

    // Actualizar serie
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
            'actor' => 'required|string',
            'director' => 'required|string',
            'video_url' => 'required|url',
            'num_episode' => 'required|integer',
            'image' => 'nullable|image|max:2048',
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

    // Eliminar serie
    public function destroy($id)
    {
        $serie = Serie::findOrFail($id);
        $serie->delete();

        return redirect()->route('admin.seriesPanel')->with('success', 'Serie eliminada con éxito.');
    }

    // Mostrar episodios de una serie específica en el panel admin
public function adminEpisodes($id)
{
    // Buscar la serie
    $serie = Serie::with('episodes')->findOrFail($id);

    // Obtener todos los episodios de esa serie
    $episodes = $serie->episodes()->orderBy('season')->orderBy('episode_number')->get();

    return view('admin.episodesPanel', compact('serie', 'episodes'));
}


// En SeriesListController.php
public function seriesPanel()
{
    $seriesList = Serie::all();
    return view('admin.seriesPanel', compact('seriesList'));
}


}
