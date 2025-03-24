<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Episode;
use App\Models\Serie;

class EpisodeSeeder extends Seeder {
    public function run() {
        $berlin = Serie::where('name', 'Berlin')->first();
        $squidGame = Serie::where('name', 'Squid Game')->first();

        Episode::create([
            'serie_id' => $berlin->id,
            'title' => 'Plan Maestro',
            'season' => 1,
            'episode_number' => 1,
            'video_url' => 'https://www.youtube.com/watch?v=berlin_episode_1'
        ]);

        Episode::create([
            'serie_id' => $squidGame->id,
            'title' => 'El Juego Comienza',
            'season' => 1,
            'episode_number' => 1,
            'video_url' => 'https://www.youtube.com/watch?v=squid_game_episode_1'
        ]);
    }
}

