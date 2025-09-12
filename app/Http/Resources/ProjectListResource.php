<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectListResource extends JsonResource
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
            'slug' => Str::slug($this->title),
            'description' => Str::limit($this->description, 60),
            'image_url' => $this->image_url ? Storage::temporaryUrl($this->image_url, now()->addMinutes(5)) : null,
            'demo_url' => $this->demo_url,
            'github_url' => $this->github_url,
            'category' => $this->whenLoaded('category', fn() => $this->category->name),
            'technologies' => $this->whenLoaded('skills', fn() => $this->skills->pluck('name')),
        ];
    }
}
