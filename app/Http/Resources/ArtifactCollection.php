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
                'id' => $artifact->id ? $artifact->id : "",
                'name' => $artifact->name ? $artifact->name : "",
                'grade' => $artifact->grade ? $artifact->grade : "",
                'description' => $artifact->description ? $artifact->description : "",
                'address' => $artifact->address ? $artifact->address : "",
                'initial_year' => $artifact->initial_year ? $artifact->initial_year : "",
                'latitude' => $artifact->location ? $artifact->location->latitude : "",
                'longitude' => $artifact->location ? $artifact->location->longitude : "",
                'images' => $artifact->images ? $artifact->images : "",
                'collections' => $artifact->collections ? $artifact->collections : "",
                'primaryImage' => $primaryImage ? $primaryImage : ""
            ];
        });
    }
}
