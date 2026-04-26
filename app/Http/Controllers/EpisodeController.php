<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Serie;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    public function create(Request $request)
    {
        $series = Serie::all();
        $selectedSerie = null;
        $seasons = collect();
        $selectedSeason = null;
        $nextEpisode = null;
        $autoMessage = null;

        if ($request->isMethod('post') && $request->filled('serie_id')) {
            $selectedSerie = Serie::find($request->serie_id);

            if ($selectedSerie) {
                $seasons = Episode::where('serie_id', $selectedSerie->id)
                    ->pluck('season')
                    ->unique()
                    ->sort()
                    ->values();

                if ($request->filled('season')) {
                    $selectedSeason = (int) $request->season;
                    $nextEpisode = Episode::where('serie_id', $selectedSerie->id)
                        ->where('season', $selectedSeason)
                        ->count() + 1;
                } elseif ($seasons->isEmpty()) {
                    $selectedSeason = 1;
                    $nextEpisode = 1;
                    $autoMessage = 'Esta serie no tiene episodios. Se asignará automáticamente la temporada 1.';
                } elseif ($seasons->count() === 1) {
                    $selectedSeason = $seasons->first();
                    $nextEpisode = Episode::where('serie_id', $selectedSerie->id)
                        ->where('season', $selectedSeason)
                        ->count() + 1;
                    $autoMessage = 'Solo hay una temporada registrada. Se ha seleccionado automáticamente.';
                }
            }
        }

        return view('admin.addEpisode', compact(
            'series',
            'selectedSerie',
            'seasons',
            'selectedSeason',
            'nextEpisode',
            'autoMessage'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'serie_id' => 'required|exists:series,id',
            'title' => 'required|string|max:255',
            'season' => 'required|integer|min:1',
            'episode_number' => 'required|integer|min:1',
            'video_url' => 'required|url',
            'image' => 'nullable|image|max:2048',
        ]);

        $exists = Episode::where('serie_id', $request->serie_id)
            ->where('season', $request->season)
            ->where('episode_number', $request->episode_number)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['episode_number' => 'Este número de episodio ya existe en la temporada.'])
                ->withInput();
        }

        $episode = new Episode();
        $episode->serie_id = $request->serie_id;
        $episode->title = $request->title;
        $episode->season = $request->season;
        $episode->episode_number = $request->episode_number;
        $episode->video_url = $request->video_url;

        if ($request->hasFile('image')) {
            $episode->image = $request->file('image')->store('episodes', 'public');
        }

        $episode->save();

        return redirect()->route('addEpisode')->with('success', 'Episodio añadido con éxito');
    }

    public function episodesPanel($serieId)
    {
        $serie = Serie::findOrFail($serieId);
        $episodes = Episode::where('serie_id', $serieId)
            ->orderBy('season')
            ->orderBy('episode_number')
            ->get();

        return view('admin.episodesPanel', compact('serie', 'episodes'));
    }

    public function edit($id)
    {
        $episode = Episode::findOrFail($id);
        return view('admin.editEpisode', compact('episode'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
            'image' => 'nullable|image|max:2048',
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

    public function destroy($id)
    {
        $episode = Episode::findOrFail($id);
        $serieId = $episode->serie_id;
        $episode->delete();

        return redirect()->route('admin.episodesPanel', $serieId)
            ->with('success', 'Episodio eliminado correctamente.');
    }
}
