<?php

namespace App\Http\Controllers;

use  Spotify;
use App\Models\Album;
use App\Models\Track;
use App\Models\Artist;
use App\Mail\MailTrack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WebTestController extends Controller
{
    public function test(Request $request)
    {

        $mailData = [
            'name' => 'Track New',
            'data' => 'Email Success Send',
        ];

      Mail::to('info@api-case.test')->send(new MailTrack($mailData));

     return response()->json(['message' => 'Mail sent successfully']);

    // return   $tracks = Spotify::searchTracks('Sagopa Kajmer')->get();
    return $tracks = Spotify::artistAlbums('1KXTegXtnCPKXjRaX1llcD')->country('TR')->get();
        foreach ($tracks as $track) {
            foreach ($track['items'] as $item) {

                foreach ($item['artists'] as $artist) {
                    $artistItem = Artist::findOrCreate($item['name'], [
                        'name' => $item['name'],
                        ]);
                }

                $trackItem = Track::findOrCreateByName($item['name'], [
                    'name' => $item['name'],
                    'popularity' => $item['popularity'],
                    'track_number' => $item['track_number'],
                    'uri' => $item['uri'],
                ]);


                Album::createWithTrack($trackItem, [
                    'name' => $item['name'],
                    'uri' => $item['uri'],
                    'artist_id' => $artist->artist_id,
                ]);
            }
        }

        return "";
    }
}
