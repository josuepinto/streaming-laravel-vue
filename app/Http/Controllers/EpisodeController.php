<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Episode;
use App\Models\Serie;

class EpisodeController extends Controller
{
    /**
     * Muestra el formulario de creación de un episodio.
     * Maneja lógica para preseleccionar temporada y calcular número de episodio.
     */
    public function create(Request $request)
    {
        $series = Serie::all(); // todas las series para el desplegable
        $selectedSerie = null;
        $seasons = collect();
        $selectedSeason = null;
        $nextEpisode = null;
        $autoMessage = null;

        // Si se seleccionó una serie
        if ($request->isMethod('post') && $request->filled('serie_id')) {
            $selectedSerie = Serie::find($request->serie_id);

            // Obtener temporadas existentes para esa serie
            $seasons = Episode::where('serie_id', $selectedSerie->id)
                              ->pluck('season')->unique()->sort();

            // 1. ✅ Si el usuario seleccionó temporada manualmente
            if ($request->filled('season')) {
                $selectedSeason = $request->season;
                $nextEpisode = Episode::where('serie_id', $selectedSerie->id)
                                      ->where('season', $selectedSeason)
                                      ->count() + 1;
            }

            // 2. ✅ Si no hay ninguna temporada todavía
            elseif ($seasons->count() === 0) {
                $selectedSeason = 1;
                $nextEpisode = 1;
                $autoMessage = 'Esta serie no tiene episodios. Se asignará automáticamente la temporada 1.';
            }

            // 3. ✅ CORREGIDO: Si hay solo una temporada (ej. temporada 1)
            elseif ($seasons->count() === 1) {
                $selectedSeason = $seasons->first(); // usualmente es 1
                $nextEpisode = Episode::where('serie_id', $selectedSerie->id)
                                      ->where('season', $selectedSeason)
                                      ->count() + 1;
                $autoMessage = 'Solo hay una temporada registrada. Se ha seleccionado automáticamente.';
            }

            // 4. Si hay más de una temporada, se esperará a que el usuario elija manualmente
        }

        // Enviar datos a la vista addEpisode
        return view('admin.addEpisode', compact(
            'series', 'selectedSerie', 'seasons', 'selectedSeason', 'nextEpisode', 'autoMessage'
        ));
    }

    /**
     * Guarda un nuevo episodio en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de campos
        $request->validate([
            'serie_id' => 'required|exists:series,id',
            'title' => 'required|string|max:255',
            'season' => 'required|integer|min:1',
            'episode_number' => 'required|integer|min:1',
            'video_url' => 'required|url',
            'image' => 'nullable|image|max:2048'
        ]);

        // Verificar si ya existe ese número de episodio en esa temporada
        $exists = Episode::where('serie_id', $request->serie_id)
                         ->where('season', $request->season)
                         ->where('episode_number', $request->episode_number)
                         ->exists();

        if ($exists) {
            return back()->withErrors(['episode_number' => 'Este número de episodio ya existe en la temporada.'])->withInput();
        }

        // Preparar datos
        $data = $request->all();

        // Guardar imagen si se subió
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('episodes', 'public');
        }

        // Crear episodio
        Episode::create($data);

        return redirect()->route('addEpisode')->with('success', 'Episodio añadido con éxito');
    }

    /**
     * Muestra todos los episodios de una serie para gestión desde el panel admin.
     */
    public function episodesPanel($serieId)
    {
        $serie = Serie::findOrFail($serieId);
        $episodes = Episode::where('serie_id', $serieId)->orderBy('season')->orderBy('episode_number')->get();

        return view('admin.episodesPanel', compact('serie', 'episodes'));
    }

    /**
     * Muestra el formulario de edición de un episodio.
     */
    public function edit($id)
    {
        $episode = Episode::findOrFail($id);
        return view('admin.editEpisode', compact('episode'));
    }

    /**
     * Actualiza un episodio existente.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
            'image' => 'nullable|image|max:2048'
        ]);

        $episode = Episode::findOrFail($id);

        $episode->title = $request->title;
        $episode->video_url = $request->video_url;

        if ($request->hasFile('image')) {
            $episode->image = $request->file('image')->store('episodes', 'public');
        }

        $episode->save();

        return redirect()->route('admin.episodesPanel', $episode->serie_id)
                         ->with('success', 'Episodio actualizado correctamente.');
    }

    /**
     * Elimina un episodio.
     */
    public function destroy($id)
    {
        $episode = Episode::findOrFail($id);
        $serieId = $episode->serie_id;
        $episode->delete();

        return redirect()->route('admin.episodesPanel', $serieId)
                         ->with('success', 'Episodio eliminado correctamente.');
    }
}
