<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'summary' => $this->short_description ?: $this->description,
            'thumbnail' => $this->thumbnail
                ? asset('storage/'.$this->thumbnail)
                : ($this->image ?: null),
            'category' => $this->categoryRelation?->name ?: $this->category,
            'technologies' => [],
        ];
    }
}
