<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
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
            'level' => $this->level,
            'mode' => $this->mode,
            'duration' => $this->duration,
            'faculty_or_school' => $this->faculty_or_school,
            'entry_requirements' => $this->entry_requirements,
            'tuition_fee' => $this->tuition_fee,
            'currency' => $this->currency,
            'language_of_instruction' => $this->language_of_instruction,
            'institution' => new InstitutionResource($this->whenLoaded('institution')),
        ];
    }
}
