<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GenceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'artist_id' => $this->artist_id,
            'name' => $this->name,
            'artist' => new ArtistResource($this->whenLoaded('artist')),
        ];
    }
}
