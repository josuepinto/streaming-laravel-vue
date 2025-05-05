<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Serie;
use App\Models\Episode;

class SerieSeeder extends Seeder
{
    public function run()
    {
        // 🟥 1. Berlin
        $berlin = Serie::create([
            'name' => 'Berlin',
            'image' => 'image/itachi.jpg',
            'actor' => 'Pedro Alonso, Joel Sanchez, Maria Isabel',
            'director' => 'Alex Pina',
            'desc' => 'The Energy of Love. During his glory days, Berlin assembles a gang in Paris for an almost impossible heist for 44M €.',
            'num_episode'=> 2,
            'video_url' => 'https://www.youtube.com/watch?v=fpeXTzkoT_k'
        ]);

        $berlin->episodes()->createMany([
            [
                'title' => 'Berlin Episodio 1',
                'season' => 1,
                'episode_number' => 1,
                'video_url' => 'https://www.youtube.com/watch?v=abc123',
                'image' => $berlin->image // ← Reutiliza imagen de la serie
            ],
            [
                'title' => 'Berlin Episodio 2',
                'season' => 1,
                'episode_number' => 2,
                'video_url' => 'https://www.youtube.com/watch?v=def456',
                'image' => $berlin->image
            ]
        ]);

        // 🟩 2. Squid Game
        $squid = Serie::create([
            'name' => 'Squid Game',
            'image' => 'image/kakashi.jpg',
            'actor' => 'Lee Jung, Park',
            'director' => 'Hwang Dong-hyuk',
            'desc' => "A deadly game for 456 players in deep financial hardship.",
            'num_episode' => 2,
            'video_url' => 'https://www.youtube.com/watch?v=SbAKYgfYET8'
        ]);

        $squid->episodes()->createMany([
            [
                'title' => 'Squid Game Episodio 1',
                'season' => 1,
                'episode_number' => 1,
                'video_url' => 'https://www.youtube.com/watch?v=ghi789',
                'image' => $squid->image
            ],
            [
                'title' => 'Squid Game Episodio 2',
                'season' => 1,
                'episode_number' => 2,
                'video_url' => 'https://www.youtube.com/watch?v=jkl012',
                'image' => $squid->image
            ]
        ]);

        // 🟦 3. Toxic Town
        $toxic = Serie::create([
            'name' => 'Toxic Town',
            'image' => 'image/kurama.jpg',
            'actor' => 'Jodie, Joe, Aimee Lou',
            'director' => 'Minkie & Spiro',
            'desc' => 'Families fighting for justice after children... pollution.',
            'num_episode' => 2,
            'video_url' => 'https://www.youtube.com/watch?v=ie6WSX0py58'
        ]);

        $toxic->episodes()->createMany([
            [
                'title' => 'Toxic Town Episodio 1',
                'season' => 1,
                'episode_number' => 1,
                'video_url' => 'https://www.youtube.com/watch?v=mno345',
                'image' => $toxic->image
            ],
            [
                'title' => 'Toxic Town Episodio 2',
                'season' => 1,
                'episode_number' => 2,
                'video_url' => 'https://www.youtube.com/watch?v=pqr678',
                'image' => $toxic->image
            ]
        ]);
    }
}
