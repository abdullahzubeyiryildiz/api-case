<?php

namespace App\Http\Controllers\Api;

use HttpResponses;
use Illuminate\Http\Request;
use App\Services\AlbumService;
use App\Http\Controllers\Controller;

class AlbumController extends Controller
{
    protected $albumService;

    public function __construct(AlbumService $albumService)
    {
        $this->albumService = $albumService;
    }

    public function getAlbumsList(Request $request, $artistID)
    {
        $perPage = $request->query('per_page', 10);

         return $this->albumService->getAlbums($artistID, $perPage);
    }
}
