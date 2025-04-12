<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstitutionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'type' => $this->type,
            'accreditation_status' => $this->accreditation_status,
            'ownership_type' => $this->ownership_type,
            'founded_year' => $this->founded_year,
            'website_url' => $this->website_url,
            'email' => $this->email,
            'phone' => $this->phone,
            'logo_url' => $this->logo_url,
            'location_id' => $this->location_id,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'location' => new LocationResource($this->whenLoaded('location')),
        ];
    }
}
