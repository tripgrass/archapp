<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CollectionResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($collection) {


            return [
                'id' => $collection->id,
                'name' => $collection->name,
                'artifacts' => $collection->artifacts,
                'public' => $collection->public,
                'user_id' => $collection->user_id
            ];
        });
    }
}
