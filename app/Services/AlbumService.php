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


}
