<?php

namespace App\Repositories;

use App\Models\Album;
use App\Models\Genre;
use App\Models\Artist;
use App\Http\Resources\AlbumResource;

class AlbumRepository
{

    public function getAlbums($artistID, $perPage)
    {
        return Album::where('artist_id', $artistID)->paginate($perPage);
    }


    public function getWith($artistID, $perPage, $searchGenre = null)
    {
        $query = Album::where('artist_id', $artistID)->with(['artist', 'tracks.gences']);

        if ($searchGenre) {
            $query->whereHas('tracks.gences', function ($q) use ($searchGenre) {
                return $q->where('name', $searchGenre);
            });
        }

         $albums = $query->paginate($perPage);
        return AlbumResource::collection($albums);
    }


    public function getGenre($artistID, $perPage, $searchGenre = null)
    {
        $query = Genre::orderBy('created_at', 'desc')->with('track.album.artist');

        if ($searchGenre) {
            $query->where('name', 'like', '%' . $searchGenre . '%');
        }

        $albums = $query->paginate($perPage);
        return $albums;
    }


}
