<?php

namespace Database\Factories;

use App\Models\Track;
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
            'track_id' => Track::factory()->create()->id,
            'name' => $array[$randomIndex],
        ];
    }
}
