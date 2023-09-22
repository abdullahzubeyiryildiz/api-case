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
        $trackCount = Track::where('album_id', $album->id)->count();
        $album->track_number = $trackCount+1;
        $album->save();

        return [
            'artist_id' => $album->artist_id,
            'album_id' => $album->id,
            'name' => $this->faker->word,
            'uri' => $this->faker->url,
        ];
    }
}
