<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Episode;
use App\Models\Serie;

class EpisodeController extends Controller {

    public function create() {
        $series = Serie::all();
        return view('episodes.create', compact('series'));
    }

    public function store(Request $request) {
        $request->validate([
            'serie_id' => 'required|exists:series,id',
            'title' => 'required|string|max:255',
            'season' => 'required|integer',
            'episode_number' => 'required|integer',
            'video_url' => 'required|url'
        ]);

        Episode::create($request->all());

        return redirect()->route('series.index')->with('success', 'Episodio añadido con éxito');
    }
}
