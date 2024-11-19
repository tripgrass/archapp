<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ImageCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($image) {
            return [
                'id' => $image->id,
                'year' => $image->year,
                'name' => $image->name,
                'title' => $image->title,
                'alttext' => $image->alttext,
                'person' => $image->person,
                'artifacts' => $image->artifacts
            ];
        });
    }
}
