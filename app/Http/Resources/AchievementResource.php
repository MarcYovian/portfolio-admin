<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AchievementResource extends JsonResource
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
            'title' => $this->title,
            'issuer' => $this->issuer,
            'date' => $this->date->format('M Y'),
            'image_url' => Storage::temporaryUrl($this->image_url, now()->addMinutes(5)),
            'limited_description' => Str::limit($this->description, 60),
            'description' => $this->description,
            'credential_url' => $this->credential_url,
            'tags' => $this->whenLoaded('tags', fn() => $this->tags->pluck('name')),
        ];
    }
}
