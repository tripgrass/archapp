<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Image extends JsonResource
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
            'id'            => $this->id,
            'year' => $this->year,
            'title' => $this->title,
            'alttext' => $this->alttext,
            'person' => $this->person,
            'artifacts' => $this->artifacts
        ];        
    }
}
