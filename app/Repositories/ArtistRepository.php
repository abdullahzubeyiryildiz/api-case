<?php

namespace App\Repositories;


use App\Models\Album;
use App\Models\Genre;
use App\Models\Track;
use Illuminate\Database\Eloquent\Collection;

class ArtistRepository
{
    protected $model;

    public function __construct(Album $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getPaginate($perPage)
    {
        return $this->model->paginate($perPage);
    }


    public function filterByArtist($artistID, $perPage)
    {
        return $this->model->where('artist_id', $artistID)->paginate($perPage);
    }

    public function filterByArtistAndLoadRelations($artistID, $perPage)
    {
        return $this->model->where('artist_id', $artistID)
            ->with(['artist.gences', 'tracks'])
            ->paginate($perPage);
    }


    public function filterByTrackAndArtistLoadRelations($artistID, $perPage)
    {
        return  Track::where('artist_id', $artistID)
            ->with('artist')
            ->paginate($perPage);
    }


    public function filterByGenre($artistID, $searchGenre, $perPage)
    {
        return Genre::where('artist_id', $artistID)->with('artist.albums')
            ->when(!empty($searchGenre), function ($query) use ($searchGenre) {
                $query->where('name', $searchGenre);
            })
            ->paginate($perPage);
    }


}
