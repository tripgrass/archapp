<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Image;

class CollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'description' => $this->description,
            'artifacts' => $this->artifacts,
            'image_id' => $this->image_id,
            'image' => ( $this->image_id ? Image::findOrFail($this->image_id) : null ) 
        ];        
    }
}
