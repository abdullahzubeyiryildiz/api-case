<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrackResource extends JsonResource
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
            'name' => $this->name,
            'album_id' => $this->album_id,
            'popularity' => $this->popularity,
            'track_number' => $this->track_number,
            'gences' => GenceResource::collection($this->whenLoaded('gences')),
        ];
    }
}
