<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SpotifyCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spotify:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Spotify Cron';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        app('App\Services\SpotifyCronService')->processSpotifyData();

        $this->info('Spotify cron job completed.');
    }
}
