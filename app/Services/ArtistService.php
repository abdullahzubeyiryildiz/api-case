<?php
namespace App\Services;

use App\Repositories\ArtistRepository;

class ArtistService
{
    protected $artistRepository;

    public function __construct(ArtistRepository $artistRepository)
    {
        $this->artistRepository = $artistRepository;
    }

    public function getAllAlbums($perPage)
    {
        return $this->artistRepository->getAll($perPage);
    }

    public function getPaginateAlbums($perPage)
    {
        return $this->artistRepository->getPaginate($perPage);
    }


    public function getAlbumsByArtist($artistID, $perPage)
    {
        return $this->artistRepository->filterByArtist($artistID, $perPage);
    }

    public function getAlbumsWithArtistAndTracks($artistID, $perPage)
    {
        return $this->artistRepository->filterByArtistAndLoadRelations($artistID, $perPage);
    }



    public function getTrackWithArtist($artistID, $perPage)
    {
        return $this->artistRepository->filterByTrackAndArtistLoadRelations($artistID, $perPage);
    }


    public function getAlbumsByGenre($artistID, $searchGenre, $perPage)
    {
        return $this->artistRepository->filterByGenre($artistID, $searchGenre, $perPage);
    }

}
