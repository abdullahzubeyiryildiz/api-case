<?php

namespace Database\Factories;

use App\Models\Album;
use App\Models\Track;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Track>
 */
class TrackFactory extends Factory
{
    protected $model = Track::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $album = Album::inRandomOrder()->first();

        $trackCount = Album::where('artist_id', $album->artist_id)->count();
        return [
            'album_id' => $album->id,
            'name' => $this->faker->word,
            'popularity' => $this->faker->numberBetween(1, 100),
            'track_number' => $trackCount,
            'uri' => $this->faker->url,
        ];
    }
}
