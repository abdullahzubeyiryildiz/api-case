<?php
namespace App\Services;

use Spotify;
use App\Models\Album;
use App\Models\Genre;
use App\Models\Track;
use App\Models\Artist;
use App\Mail\MailTrack;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SpotifyCronService
{
    public function processSpotifyData()
    {
        try {
            $searchQuery = 'Sagopa Kajmer';
            $tracks = Spotify::searchTracks($searchQuery)->get();

            foreach ($tracks as $track) {
                foreach ($track['items'] as $item) {
                    $artistName = $item['artists'][0]['name'];
                    $artistItem = $this->getOrCreateArtist($artistName);

                    $artistAlbums = Spotify::artistAlbums($item['artists'][0]['id'])->country('TR')->get();

                    foreach ($artistAlbums['items'] as $albumItem) {
                        $albumModel = $this->getOrCreateAlbum($albumItem, $artistItem);
                        $this->processAlbumTracks($albumModel, $albumItem);
                    }
                }
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    private function getOrCreateArtist($artistName)
    {
        return Artist::firstOrCreate(['name' => $artistName]);
    }

    private function getOrCreateAlbum($albumItem, $artistItem)
    {
        return Album::firstOrCreate(['name' => $albumItem['name']], [
            'name' => $albumItem['name'],
            'artist_id' => $artistItem->id,
            'total_tracks' => $albumItem['total_tracks'],
            'uri' => $albumItem['uri'],
        ]);
    }

    private function processAlbumTracks($albumModel, $albumItem)
    {
        $albumTracks = Spotify::albumTracks($albumItem['id'])->get();

        foreach ($albumTracks['items'] as $albumTrack) {
            $trackAttributes = [
                'name' => $albumTrack['name'],
                'uri' => $albumTrack['uri'],
                'album_id' => $albumModel->id,
            ];

            $track = $this->getOrCreateTrack($trackAttributes);
            $this->processTrackGenres($track, $albumTrack['genres'] ?? null);
            $this->checkAndUpdateTotalTracks($albumModel, $albumItem);
        }
    }

    private function getOrCreateTrack($trackAttributes)
    {
        return Track::firstOrCreate(['name' => $trackAttributes['name']], $trackAttributes);
    }

    private function processTrackGenres($track, $genres = null)
    {
        if (!empty($genres)) {
            foreach ($genres as $genre) {
                Genre::firstOrCreate(['name' => $genre, 'track_id' => $track->id]);
            }
        }
    }

    private function checkAndUpdateTotalTracks($albumModel, $albumItem)
    {
        if ($albumModel->total_tracks != $albumItem['total_tracks']) {
            $message = "Album: {$albumModel->name} has a new total_tracks value. New count: {$albumModel->total_tracks}, Spotify Total: {$albumItem['total_tracks']}";

            $mailData = [
                'name' => 'TotalTracks New',
                'data' => $message,
            ];

            $albumModel->total_tracks = $albumItem['total_tracks'];
            $albumModel->save();

            Mail::to('info@api-case.test')->send(new MailTrack($mailData));
        } else {
            $message = "No change";
            Log::info($message);
        }
    }
}
