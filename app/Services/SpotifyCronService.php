<?php
namespace App\Services;

use Spotify;
use Exception;
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
            $spotifyTracks = Spotify::searchTracks($searchQuery)->get();

            foreach ($spotifyTracks as $spotifyTrack) {
                foreach ($spotifyTrack['items'] as $trackItem) {
                    $artistName = $trackItem['artists'][0]['name'];
                    $artistID = $trackItem['artists'][0]['id'];

                    $artistSpotify = Spotify::artist($artistID)->get();

                    $artistModel = $this->getOrCreateArtist($artistName, $artistID);

                    $this->processArtistGenres($artistModel, $artistSpotify['genres'] ?? null);

                    $this->processArtistAlbums($artistModel);
                }
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    private function getOrCreateArtist($artistName, $artistID)
    {
        return Artist::firstOrCreate(['name' => $artistName, 'id' => $artistID]);
    }

    private function processArtistGenres($artistModel, $genres = null)
    {
        if (!empty($genres)) {
            foreach ($genres as $genre) {
                Genre::firstOrCreate(['name' => $genre, 'artist_id' => $artistModel->id]);
            }
        }
    }

    private function processArtistAlbums($artistModel)
    {
        $spotifyArtistAlbums = Spotify::artistAlbums($artistModel->id)->country('TR')->get();

        foreach ($spotifyArtistAlbums['items'] as $albumItem) {
            $albumModel = $this->getOrCreateAlbum($artistModel, $albumItem);
            $this->processAlbumTracks($albumModel, $albumItem);
        }
    }

    private function getOrCreateAlbum($artistModel, $albumItem)
    {
        return Album::firstOrCreate(['name' => $albumItem['name'], 'id' => $albumItem['id']], [
            'name' => $albumItem['name'],
            'artist_id' => $artistModel->id,
            'uri' => $albumItem['uri'],
            'popularity' => $albumItem['popularity'] ?? 0,
            'track_number' => $albumItem['total_tracks'] ?? 0,
        ]);
    }

    private function processAlbumTracks($albumModel, $albumItem)
    {
        $spotifyAlbumTracks = Spotify::albumTracks($albumItem['id'])->get();

        foreach ($spotifyAlbumTracks['items'] as $albumTrack) {
            $this->getOrCreateTrack($albumModel, $albumTrack);
        }

        $this->checkAndUpdateTotalTracks($albumModel, $albumItem);
    }

    private function getOrCreateTrack($albumModel, $albumTrack)
    {
        return Track::firstOrCreate(['name' => $albumTrack['name'], 'id' => $albumTrack['id']], [
            'id' => $albumTrack['id'],
            'name' => $albumTrack['name'],
            'uri' => $albumTrack['uri'],
            'artist_id' => $albumModel->artist_id,
            'album_id' => $albumModel->id,
        ]);
    }

    private function checkAndUpdateTotalTracks($albumModel, $albumItem)
    {
        if (isset($albumItem['total_tracks']) && $albumModel->track_number != $albumItem['total_tracks']) {
            $message = "Album: {$albumModel->name} has a new total_tracks value. New count: {$albumModel->track_number}, Spotify Total: {$albumItem['total_tracks']}";

            $mailData = [
                'name' => 'TotalTracks New',
                'data' => $message,
            ];

            $albumModel->track_number = $albumItem['total_tracks'];
            $albumModel->save();

            Mail::to('info@api-case.test')->send(new MailTrack($mailData));
        } else {
            $message = "No change";
            Log::info($message);
        }
    }
}
