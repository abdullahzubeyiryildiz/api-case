<?php

namespace App\Http\Controllers\Api;


use Spotify;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;


class SpotifyController extends Controller
{

    public function getArtistList(){

    }
    public function getTracksList(Request $request)
    {
        return Spotify::searchTracks('külliyatı')->get();
        $tracks = $spotifyService->getAlbums();
        return response()->json($tracks);
    }
}
