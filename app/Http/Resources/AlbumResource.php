<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class AlbumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'artist_id' => $this->artist_id,
            'popularity' => $this->popularity,
            'track_number' => $this->total_number,
            'artist' => new ArtistResource($this->whenLoaded('artist')),
            'tracks' => TrackResource::collection($this->whenLoaded('tracks')),
        ];
    }
}
