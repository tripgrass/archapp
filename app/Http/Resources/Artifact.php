<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Artifact extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'location'   => $this->location,
            'latitude' => $this->location ? $article->location->latitude : null,
            'longitude' => $this->location ? $article->location->longitude : null,            
            'area'   => $this->area,
            'address'   => $this->address,
            'city'   => $this->city,
            'state'   => $this->state,
            'zipcode'   => $this->zipcode,
            'eloGroup'   => $this->eloGroup,            
            'scale'   =>    $this->scale,            
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'images'     => $this->images
        ];        
    }
}
