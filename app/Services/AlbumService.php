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

    public function getAlbums($artistID, $perPage)
    {
        return $this->albumRepository->getAlbums($artistID, $perPage);
    }


    public function getWith($artistID, $perPage, $searchGenre = null)
    {
        return $this->albumRepository->getWith($artistID, $perPage, $searchGenre);
    }


    public function getGenre($perPage, $searchGenre = null)
    {
        return $this->albumRepository->getGenre($perPage, $searchGenre);
    }

}
