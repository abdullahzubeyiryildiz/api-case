<?php

namespace Database\Factories;

use App\Models\Album;
use App\Models\Track;
use App\Models\Artist;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Genre>
 */
class GenreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $array = ['arabesque', 'rap', 'pop'];
        $randomIndex = array_rand($array);

        return [
            'artist_id' => Album::factory()->create()->artist_id,
            'name' => $array[$randomIndex],
        ];
    }
}
