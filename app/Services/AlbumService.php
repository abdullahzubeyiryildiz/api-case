<?php
namespace App\Services;

use App\Repositories\AlbumRepository;

class AlbumService
{
    protected $albumRepository;

    public function __construct(AlbumRepository $albumRepository)
    {
        $this->albumRepository = $albumRepository;
    }

    public function getAllAlbums()
    {
        return $this->albumRepository->getAll();
    }

    public function getAlbumsByArtist($artistID, $perPage)
    {
        return $this->albumRepository->filterByArtist($artistID, $perPage);
    }

    public function getAlbumsWithArtistAndTracks($artistID, $perPage)
    {
        return $this->albumRepository->filterByArtistAndLoadRelations($artistID, $perPage);
    }

    public function getAlbumsByGenre($searchGenre, $perPage)
    {
        return $this->albumRepository->filterByGenre($searchGenre, $perPage);
    }

}
