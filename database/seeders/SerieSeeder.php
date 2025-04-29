<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Serie;

class SerieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ex to make a serie using Serie model
        Serie::create([
            'name' => 'Berlin',
            'image' => 'series_images/0RC5THrMSruA6MRSMo2pGPlV5VBEp0mEMTmE9ZmA.jpg',
            'actor' => 'Pedro Alonso, Joel Sanchez, Maria Isabel',
            'director' => 'Alex Pina',
            'desc' => 'The Energy of Love. During his glory days, Berlin assembles a gang in Paris for an almost impossible heist for 44M €.',
            'num_episode'=> 1,
            'video_url' => 'https://www.youtube.com/watch?v=fpeXTzkoT_k&pp=ygUNYmVybGluIHNlcmllcw%3D%3D'
        ]);
        Serie::create([
            'name' => 'Squid Game',
            'image' => 'series_images/eBl9C7w2BWx97fsSMuJFjWrxZzfX6QS2Ka2UEhE3.jpg',
            'actor' => 'Lee Jung, Park',
            'director' => 'Hwang Dong-hyuk',
            'desc' => "It revolves around a secret contest where 456 players, all of whom are in deep financial hardship, risk their lives to play a series of deadly children's games.",
            'num_episode' => 1,
            'video_url' => 'https://www.youtube.com/watch?v=SbAKYgfYET8&pp=ygUKc3F1aWQgZ2FtZQ%3D%3D'
        ]);
        Serie::create([
            'name' => 'Toxic Town',
            'image' => 'series_images/O2qfHkU1Fqci9hN9UujVT86ro3JY45fJoTYQD7FG.jpg',
            'actor' => 'Jodie, Joe, Aimee Lou',
            'director' => 'Minkie & Spiro',
            'desc' => 'Families fighting for justice after children in the Northamptonshire town were born with birth defects, believed to be caused by industrial pollution.',
            'num_episode' => 1,
            'video_url' => 'https://www.youtube.com/watch?v=ie6WSX0py58&pp=ygUSdG94aWMgdG93biB0cmFpbGVy'
        ]);
    }
}
