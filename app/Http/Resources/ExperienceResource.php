<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'role' => $this->role,
            'company' => $this->company,
            'period' => $this->start_date->format('M Y') . ' - ' . ($this->end_date ? $this->end_date->format('M Y') : 'Present'),
            'description' => $this->description,
            'achievements' => collect($this->achievements)->pluck('achievement_text')->toArray(),
            'skills' => $this->whenLoaded('skills', fn() => $this->skills->pluck('name'))
        ];
    }
}
