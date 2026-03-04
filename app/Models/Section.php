<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'slug', 'title_en', 'title_es',
        'description_en', 'description_es',
        'section_layout', 'categories', 'order',
    ];

    protected $casts = [
        'categories' => 'array',
        'order' => 'integer',
    ];
}
