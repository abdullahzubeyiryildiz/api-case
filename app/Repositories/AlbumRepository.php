<?php

namespace App\Repositories;

use App\Models\Album;
use App\Models\Artist;

class AlbumRepository
{

    public function getAlbums($artistID, $perPage)
    {
        return Album::where('artist_id', $artistID)->paginate($perPage);
    }

}
