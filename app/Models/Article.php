<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    protected $fillable = [
        'slug', 'title_en', 'title_es',
        'summary_en', 'summary_es',
        'body_en', 'body_es',
        'image', 'category_id', 'section', 'author',
        'date', 'featured', 'priority',
    ];

    protected $casts = [
        'date' => 'date',
        'featured' => 'boolean',
        'priority' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


}
