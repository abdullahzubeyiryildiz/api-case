<?php

namespace App\Repositories;

use App\Models\Album;
use App\Models\Genre;
use App\Models\Artist;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\GenceResource;

class AlbumRepository
{

    public function getAlbums($artistID, $perPage)
    {
        return Album::where('artist_id', $artistID)->paginate($perPage);
    }


    public function getWith($artistID, $perPage, $searchGenre = null)
    {
        $query = Album::where('artist_id', $artistID)->with(['artist.gences', 'tracks']);

        $albums = $query->paginate($perPage);
        return AlbumResource::collection($albums);
    }


    public function getGenre($artistID, $perPage, $searchGenre = null)
    {
        $query = Genre::with('artist');
        if ($searchGenre) {
            $query->where(function ($q) use ($searchGenre) {
               return $q->where('name', $searchGenre);
            });
        }
        $perPage = 10;
        $albums = $query->paginate($perPage);
        return GenceResource::collection($albums);
    }


}
