<?php

namespace App\Http\Controllers\Api;

use HttpResponses;
use Illuminate\Http\Request;
use App\Services\ArtistService;
use App\Http\Controllers\Controller;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\GenceResource;
use App\Http\Resources\ArtistResource;
use App\Http\Resources\TrackWithArtistResource;

class AlbumController extends Controller
{
    protected $artistService;

    public function __construct(ArtistService $artistService)
    {
       $this->artistService = $artistService;
    }


    public function getAlbumsList(Request $request)
    {
        $perPage = $request->query('per_page', 10);

        $artists =$this->artistService->getPaginateAlbums($perPage);

        return AlbumResource::collection($artists);
    }



    /**
 * @OA\Get(
 *     path="/api/artist/{artistID}/tracks",
 *     summary="Get a list of tracks by artist",
 *     tags={"Tracks"},
 *     security={{ "bearerAuth": {} }},
 *     @OA\Parameter(
 *         name="artistID",
 *         in="path",
 *         description="ID of the artist",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="per_page",
 *         in="query",
 *         description="Number of tracks per page",
 *         required=false,
 *         @OA\Schema(
 *             type="integer",
 *             default=10,
 *         )
 *     ),
 *   @OA\Response(
 *         response=200,
 *         description="List of tracks by artist",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *         )
 *     ),
 * )
 */

 public function getArtistTrackList(Request $request, $artistID)
 {
     $perPage = $request->query('per_page', 10);

      $artists =$this->artistService->getTrackWithArtist($artistID, $perPage);

     return TrackWithArtistResource::collection($artists);
 }


/**
 * @OA\Get(
 *     path="/api/artist/{artistID}/albums",
 *     summary="Get a list of albums by artist",
 *     tags={"Albums"},
 *     security={{ "bearerAuth": {} }},
 *     @OA\Parameter(
 *         name="artistID",
 *         in="path",
 *         description="ID of the artist",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="per_page",
 *         in="query",
 *         description="Number of albums per page",
 *         required=false,
 *         @OA\Schema(
 *             type="integer",
 *             default=10,
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of albums by artist",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *         )
 *     ),
 * )
 */

    public function getArtistAlbumsList(Request $request, $artistID)
    {
        $perPage = $request->query('per_page', 10);

        $artists =$this->artistService->getAlbumsWithArtistAndTracks($artistID, $perPage);

        return AlbumResource::collection($artists);
    }




    /**
     * @OA\Get(
     *     path="/api/artist/{artistID}/genres",
     *     summary="Get a list of genres by artist",
     *     tags={"Genres"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="artistID",
     *         in="path",
     *         description="ID of the artist",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="genre",
     *         in="query",
     *         description="Filter genres by name example : turkish trap",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of genres per page",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             default=10,
     *         )
     *     ),
     *   @OA\Response(
     *         response=200,
     *         description="List of genres by artist",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     * )
     */

    public function getGenreList(Request $request, $artistID, $searchGenre = null)
    {
        $perPage = $request->query('per_page', 10);
        $searchGenre = $request->genre;

        $gences =$this->artistService->getAlbumsByGenre($artistID, $searchGenre, $perPage);

        return GenceResource::collection($gences);
    }
}
