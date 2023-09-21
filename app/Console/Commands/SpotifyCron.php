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
        $tracks = Spotify::searchTracks('Sagopa Kajmer')->get();

        foreach ($tracks as $track) {
            foreach ($track['items'] as $item) {

                $artistItem = Artist::firstOrCreate(['name' => $item['artists'][0]['name']], [
                    'name' => $item['artists'][0]['name'],
                ]);

                 $artistAlbums = Spotify::artistAlbums($item['artists'][0]['id'])->country('TR')->get();

                        foreach ($artistAlbums['items'] as $albumItem) {
                           $albumModel = Album::firstOrCreate(['name' => $albumItem['name']], [
                                'name' => $albumItem['name'],
                                'artist_id' => $artistItem->id,
                                'total_tracks' => $albumItem['total_tracks'],
                                'uri' => $albumItem['uri'],
                            ]);

                             $albumTracks = Spotify::albumTracks($albumItem['id'])->get();

                            foreach ($albumTracks['items'] as $albumTrack) {
                                $trackAttributes = [
                                    'name' => $albumTrack['name'],
                                    'uri' => $albumTrack['uri'],
                                    'album_id' => $albumModel->id,
                                ];

                               $track = Track::firstOrCreate(['name' => $albumTrack['name']], $trackAttributes);

                                if(!empty($albumTrack['genres'])) {
                                    foreach($albumTrack['genres'] as $genres) {
                                        Genre::firstOrCreate(['name' => $genres,'track_id'=>$track->id], $trackAttributes);
                                    }
                                }

                            }
                        }
            }
        }
    }
}
