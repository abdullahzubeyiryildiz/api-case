<?php

namespace App\Http\Controllers;

use  Spotify;
use App\Models\Album;
use App\Models\Genre;
use App\Models\Track;
use App\Models\Artist;
use App\Mail\MailTrack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WebTestController extends Controller
{
    public function test(Request $request)
    {

      /*  $mailData = [
            'name' => 'Track New',
            'data' => 'Email Success Send',
        ];

      Mail::to('info@api-case.test')->send(new MailTrack($mailData));

     return response()->json(['message' => 'Mail sent successfully']); */

          /*  $tracks = Spotify::searchTracks('Sagopa Kajmer')->get();

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
            } */
    }
}