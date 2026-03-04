<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'slug'       => $this->slug,
            'titleEn'    => $this->title_en,
            'titleEs'    => $this->title_es,
            'summaryEn'  => $this->summary_en,
            'summaryEs'  => $this->summary_es,
            'bodyEn'     => $this->body_en,
            'bodyEs'     => $this->body_es,
            'image'      => $this->image,
            'category'   => $this->category?->slug,
            'author'     => $this->author,
            'date'       => $this->date?->toDateString(),
            'featured'   => $this->featured,
            'priority'   => $this->priority,
        ];
    }
}
