<?php

namespace Database\Factories;

use App\Models\Album;
use App\Models\Track;
use App\Models\Artist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Album>
 */
class AlbumFactory extends Factory
{

    protected $model = Album::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $album = Album::inRandomOrder()->first();

       return [
            'artist_id' => Artist::factory(),
            'name' => $this->faker->word,
            'popularity' => $this->faker->numberBetween(1, 100),
        ];

    }
}
