<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CollectionResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($thisModel) {
Log::error(print_r($thisModel, true ));

            return [
                'nametest' => $thisModel->name,
                'artifacts' => $thisModel->artifacts
            ];
        });
    }
}
