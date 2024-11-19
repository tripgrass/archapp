<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Image;

class ArtifactCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($artifact) {

            $primaryImage = null;
            if( $artifact->primary_image_id ){
                $primaryImage = Image::findOrFail($artifact->primary_image_id);
            }

            return [
                'id' => $artifact->id,
                'name' => $artifact->name,
                'latitude' => $artifact->location ? $artifact->location->latitude : null,
                'longitude' => $artifact->location ? $artifact->location->longitude : null,
                'images' => $artifact->images,
                'primaryImage' => $primaryImage
            ];
        });
    }
}
