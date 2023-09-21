<?php

namespace Database\Seeders;

use App\Models\Track;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TrackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Track::factory(2500)->create();
    }
}
