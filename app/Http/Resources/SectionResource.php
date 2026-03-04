<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'slug'          => $this->slug,
            'titleEn'       => $this->title_en,
            'titleEs'       => $this->title_es,
            'descriptionEn' => $this->description_en,
            'descriptionEs' => $this->description_es,
            'sectionLayout' => $this->section_layout,
            'categories'    => $this->categories ?? [],
            'order'         => $this->order,
        ];
    }
}
