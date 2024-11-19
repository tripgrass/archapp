<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArtifactCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($article) {
            return [
                'id' => $article->id,
                'name' => $article->name,
                'latitude' => $article->location ? $article->location->latitude : null,
                'longitude' => $article->location ? $article->location->longitude : null,
                'images' => $article->images
            ];
        });
    }
}
