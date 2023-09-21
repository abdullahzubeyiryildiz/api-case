<?php

namespace App\Http\Controllers;

use  Spotify;
use App\Models\Album;
use App\Models\Genre;
use App\Models\Track;
use App\Models\Artist;
use App\Mail\MailTrack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\GenceResource;

class WebTestController extends Controller
{

    public function test() {
        $artistID = "1KXTegXtnCPKXjRaX1llcD";

     //   $query = Genre::where('artist_id', $artistID)->with('artist');

        $query = Genre::with('artist');
        $searchGenre= "rap";
        if ($searchGenre) {
            $query->where(function ($q) use ($searchGenre) {
               return $q->where('name', $searchGenre);
            });
        }
        $perPage = 10;
        $albums = $query->paginate($perPage);
        return GenceResource::collection($albums);
    }
  /*  public function test(Request $request)
    {
        $artistID = "9a2f63f1-f01a-468c-bd7f-dc15b2a40da9";

        $query = Album::where('artist_id', $artistID)->with(['artist', 'tracks.gences']);
        $searchGenre= "rap";
        if ($searchGenre) {
            $query->whereHas('tracks.gences', function ($q) use ($searchGenre) {
               return $q->where('name', $searchGenre);
            });
        }
        $perPage = 10;
        $albums = $query->paginate($perPage);
        return AlbumResource::collection($albums);



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
    } */




    public function test2()
    {
        try {
            $searchQuery = 'Sagopa Kajmer';
             $tracksSpotify = Spotify::searchTracks($searchQuery)->get();

            foreach ($tracksSpotify as $track) {
                foreach ($track['items'] as $item) {
                    $artistName = $item['artists'][0]['name'];
                    $artistID = $item['artists'][0]['id'];

                      $artistSpotify = Spotify::artist($artistID)->get();

                    $artistItem = $this->getOrCreateArtist($artistName,$artistID);

                    $this->processArtistGenres($artistItem, $artistSpotify['genres'] ?? null);

                    $this->processArtistAlbum($artistItem);
                }
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }


    private function getOrCreateArtist($artistName,$artistID)
    {
        return Artist::firstOrCreate(['name' => $artistName,'id'=>$artistID]);
    }


    private function processArtistGenres($albumModel, $genres = null)
    {
        if (!empty($genres)) {
            foreach ($genres as $genre) {
                Genre::firstOrCreate(['name' => $genre, 'artist_id' => $albumModel->id]);
            }
        }
    }


    private function processArtistAlbum($artistItem)
    {
        $artistAlbumsSpotify = Spotify::artistAlbums($artistItem->id)->country('TR')->get();

        foreach ($artistAlbumsSpotify['items'] as $albumItem) {
            $albumModel = $this->getOrCreateAlbum($artistItem,$albumItem);
            $this->processAlbumTracks($albumModel, $albumItem);

            $this->checkAndUpdateTotalTracks($albumModel, $albumItem);
        }
    }


    private function getOrCreateAlbum($artistItem, $albumItem)
    {
        return Album::firstOrCreate(['name' => $albumItem['name'], 'id'=>$albumItem['id']], [
            'name' => $albumItem['name'],
            'artist_id' => $artistItem->id,
            'uri' => $albumItem['uri'],
            'popularity' => $albumItem['popularity'] ?? 0,
            'track_number' => $albumItem['total_tracks'] ?? 0,
        ]);
    }

    private function processAlbumTracks($albumModel, $albumItem)
    {
        $albumTracksSpotify = Spotify::albumTracks($albumItem['id'])->get();

        foreach ($albumTracksSpotify['items'] as $albumTrack) {
            $this->getOrCreateTrack($albumModel->id,$albumTrack);
        }
    }

    private function getOrCreateTrack($albumID,$albumTrack)
    {
        return Track::firstOrCreate(['name' => $albumTrack['name'],'id' => $albumTrack['id']], [
            'id' => $albumTrack['id'],
            'name' => $albumTrack['name'],
            'uri' => $albumTrack['uri'],
            'album_id' => $albumID,
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
