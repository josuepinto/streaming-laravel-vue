<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
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
        return [
            //
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'actor' => $this->faker->sentence(1),
            'director' => $this->faker->sentence(1),
            'year' => $this->faker->year(),
            'genre' => $this->faker->randomElement(['Action', 'Comedy', 'Drama', 'Horror', 'Sci-Fi']),
            'image' => 'https://i.3djuegos.com/juegos/17674/uncharted_la_pel__cula/fotos/ficha/uncharted_la_pel__cula-5579132.webp',
            'video_url' => 'https://example.com/video.mp4'
        ];
    }
}
