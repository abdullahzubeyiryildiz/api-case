<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GenceWithArtistResource extends JsonResource
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
            'albums' =>  GenceWithAlbumResource::collection($this->whenLoaded('albums')),
        ];
    }

    public function with($request)
    {
        return [
            'meta' => [
                'pagination' => [
                    'total' => $this->collection->total(),
                    'count' => $this->collection->count(),
                    'per_page' => $this->collection->perPage(),
                    'current_page' => $this->collection->currentPage(),
                    'total_pages' => $this->collection->lastPage(),
                ],
            ],
        ];
    }
}
