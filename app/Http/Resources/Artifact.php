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
        foreach( $this->images as $key => $image ){
            
        }
        return [
            'id'         => $this->id ? $this->id : "",
            'name'       => $this->name ? $this->name : "",
            'location'   => $this->location ? $this->location : "",
            'latitude' => $this->location ? $this->location->latitude : "",
            'longitude' => $this->location ? $this->location->longitude : "",            
            'area'   => $this->area ? $this->area : "",
            'address'   => $this->address ? $this->address : "",
            'city'   => $this->city ? $this->city : "" ,
            'state'   => $this->state,
            'zipcode'   => $this->zipcode,
            'eloGroup'   => $this->eloGroup,            
            'scale'   =>    $this->scale,            
            'grade'   =>    $this->grade,            
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'images'     => $this->images,
            'collections'     => $this->collections,
            'initial_year'     => $this->initial_year,            
            'description'     => $this->description,            
            'primary_image_id' => $this->primary_image_id
        ];        
    }
}
