<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'degree' => $this->degree,
            'institution' => $this->institution,
            'period' => $this->start_date->format('M Y') . ' - ' . ($this->end_date ? $this->end_date->format('M Y') : 'Present'),
            'gpa' => $this->gpa,
            'max_gpa' => $this->max_gpa,
            'description' => $this->description,
        ];
    }
}
