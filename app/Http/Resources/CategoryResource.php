<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'slug'           => $this->slug,
            'titleEn'        => $this->title_en,
            'titleEs'        => $this->title_es,
            'defaultSection' => $this->section?->slug,
        ];
    }
}
