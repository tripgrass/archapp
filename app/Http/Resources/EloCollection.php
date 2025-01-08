<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EloCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($elo) {
            return [
                'id' => $elo->id,
            'primary_artifact_id'            => $elo->primary_artifact_id,
            'secondary_artifact_id'            => $elo->secondary_artifact_id,
            'rating_signatory' => $elo->rating_signatory,
            'rating_demos' => $elo->rating_demos,
            'category' => $elo->category                
            ];
        });
    }
}
