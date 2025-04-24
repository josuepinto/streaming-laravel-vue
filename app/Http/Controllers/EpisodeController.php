<?php
// EpisodeController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Episode;
use App\Models\Serie;

class EpisodeController extends Controller {

    public function create(Request $request)
    {
        $series = Serie::all();
        $selectedSerie = null;
        $seasons = collect();
        $selectedSeason = 1; // Por defecto siempre Temporada 1
        $nextEpisode = null;
        $autoMessage = null;

        if ($request->isMethod('post') && $request->filled('serie_id')) {
            $selectedSerie = Serie::find($request->serie_id);
            $seasons = Episode::where('serie_id', $selectedSerie->id)
                              ->pluck('season')->unique()->sort();

            // Si el usuario seleccionó manualmente una temporada
            if ($request->filled('season')) {
                $selectedSeason = $request->season;
            }

            // Calcular siguiente número de episodio
            $nextEpisode = Episode::where('serie_id', $selectedSerie->id)
                                  ->where('season', $selectedSeason)
                                  ->count() + 1;

            // Mensaje si no hay temporadas todavía
            if ($seasons->isEmpty()) {
                $autoMessage = 'Esta serie no tiene temporadas registradas. Se creará automáticamente la Temporada 1.';
            }
        }

        return view('admin.addEpisode', compact('series', 'selectedSerie', 'seasons', 'selectedSeason', 'nextEpisode', 'autoMessage'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'serie_id' => 'required|exists:series,id',
            'title' => 'required|string|max:255',
            'season' => 'required|integer|min:1',
            'episode_number' => 'required|integer|min:1',
            'video_url' => 'required|url',
            'image' => 'nullable|image|max:2048'
        ]);

        $exists = Episode::where('serie_id', $request->serie_id)
                         ->where('season', $request->season)
                         ->where('episode_number', $request->episode_number)
                         ->exists();

        if ($exists) {
            return back()->withErrors(['episode_number' => 'Este número de episodio ya existe en la temporada.'])->withInput();
        }

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('episodes', 'public');
        }

        Episode::create($data);

        return redirect()->route('addEpisode')->with('success', 'Episodio añadido con éxito');
    }
}
    
?>