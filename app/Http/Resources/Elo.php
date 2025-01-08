<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Elo extends JsonResource
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
            'primary_artifact_id'            => $this->primary_artifact_id,
            'secondary_artifact_id'            => $this->secondary_artifact_id,
            'rating_signatory' => $this->rating_signatory,
            'rating_demos' => $this->rating_demos,
            'category' => $this->category
        ];        
    }
}
