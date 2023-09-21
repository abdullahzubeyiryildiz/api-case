<?php

namespace App\Http\Controllers\Api;

use HttpResponses;
use Illuminate\Http\Request;
use App\Services\AlbumService;
use App\Http\Controllers\Controller;
use App\Http\Resources\AlbumResource;

class AlbumController extends Controller
{
    protected $albumService;

    public function __construct(AlbumService $albumService)
    {
        $this->albumService = $albumService;
    }

    public function getAlbumsList(Request $request, $artistID, $searchGenre = null)
    {
        $perPage = $request->query('per_page', 10);
         $searchGenre = $request->genre ?? "arabesque";

        return  $this->albumService->getWith($artistID, $perPage, $searchGenre);
    }


    public function getGenreList(Request $request, $artistID, $searchGenre = null)
    {
          $perPage = $request->query('per_page', 10);
          $searchGenre = $request->genre ?? "arabesque";

        return  $this->albumService->getGenre($artistID, $perPage, $searchGenre);
    }
}
