<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use App\Models\Movie;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

         // Example YouTube video IDs (you can add more or pull from a list)
        $youtubeIds = [
            'dQw4w9WgXcQ',  // Rick Astley
            'oHg5SJYRHA0',  // Same classic :)
            'eY52Zsg-KVI',  // Mark Ronson - Uptown Funk
            'hTWKbfoikeg',  // Nirvana - Smells Like Teen Spirit
            '3JZ_D3ELwOQ',  // Eminem - Lose Yourself
        ];

        $videoId = $this->faker->randomElement($youtubeIds);
        $embedUrl = "https://www.youtube.com/embed/{$videoId}";

        // Creamos una ruta única para cada imagen
        $imagePath = 'image/' . $this->faker->unique()->word . '.jpg';

       // Generamos una imagen aleatoria y la guardamos en el directorio 'public/image'
       $this->faker->image(public_path('image'), 640, 480, 'cats', false);

        return [
            //
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'actor' => $this->faker->sentence(1),
            'director' => $this->faker->sentence(1),
            'year' => $this->faker->year(),
            'genre' => $this->faker->randomElement(['Action', 'Comedy', 'Drama', 'Horror', 'Sci-Fi']),
            'image' => 'https://i.3djuegos.com/juegos/17674/uncharted_la_pel__cula/fotos/ficha/uncharted_la_pel__cula-5579132.webp',
            'video_url' => $embedUrl
        ];
    }
}
