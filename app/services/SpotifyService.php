<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SpotifyService
{
    protected $apiUrl = 'https://api.spotify.com/v1';

    public function getAccessToken()
    {
        // Spotify API'ye erişim token'ını almak için gerekli isteği yapın
        $client = new \GuzzleHttp\Client();
        $response = $client->post('https://accounts.spotify.com/api/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => env('SPOTIFY_CLIENT_ID'),
                'client_secret' => env('SPOTIFY_CLIENT_SECRET'),
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        return $data['access_token'];
    }

    public function getArtistTracks($artistId)
    {
        $accessToken = $this->getAccessToken();

        $url = $this->apiUrl . "/artists/{$artistId}/top-tracks?market=US";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get($url);

        return $response->json();
    }


    public function getAlbums()
    {
        $accessToken = $this->getAccessToken();

        $url = $this->apiUrl . "/albums";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get($url);

        return $response->json();
    }


}