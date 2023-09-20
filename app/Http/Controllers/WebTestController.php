<?php

namespace App\Http\Controllers;

use  Spotify;
use Illuminate\Http\Request;

class WebTestController extends Controller
{
    public function test(Request $request)
    {
        $tracks = Spotify::searchTracks('külliyatı')->get();

        foreach ($tracks as $track) {
            foreach ($track['items'] as $item) {
                $trackItem = Track::findOrCreateByName($item['name'], [
                    'name' => $item['name'],
                    'popularity' => $item['popularity'],
                    'track_number' => $item['track_number'],
                    'uri' => $item['uri'],
                ]);

                Album::createWithTrack($trackItem, [
                    'name' => $item['name'],
                    'uri' => $item['uri'],
                ]);
            }
        }

        return "";
    }
}
