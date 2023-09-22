<?php

namespace App\Repositories;

use App\Models\Album;
use App\Models\Genre;
use App\Models\Artist;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\GenceResource;
use Illuminate\Database\Eloquent\Collection;
class AlbumRepository
{
    protected $model;

    public function __construct(Album $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function filterByArtist($artistID, $perPage): Collection
    {
        return $this->model->where('artist_id', $artistID)->paginate($perPage);
    }

    public function filterByArtistAndLoadRelations($artistID, $perPage)
    {
        return $this->model->where('artist_id', $artistID)
            ->with(['artist.gences', 'tracks'])
            ->paginate($perPage);
    }

    public function filterByGenre($searchGenre, $perPage)
    {
        return Genre::with('artist')
            ->when($searchGenre, function ($query) use ($searchGenre) {
                $query->where('name', $searchGenre);
            })
            ->paginate($perPage);
    }


}
