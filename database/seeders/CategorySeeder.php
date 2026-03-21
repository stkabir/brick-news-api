<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Section;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Map category slug → default section slug
        $sectionDefaults = [
            'business'     => 'featured',
            'events'       => 'trending',
            'headline-news'=> 'top-stories',
            'lifestyle'    => 'featured',
            'home'         => null,
            'news'         => 'top-stories',
            'real-estate'  => 'trending',
        ];

        $sectionIds = Section::pluck('id', 'slug');

        $categories = [
            ['slug' => 'business',      'title_en' => 'Business',      'title_es' => 'Negocios'],
            ['slug' => 'events',        'title_en' => 'Events',        'title_es' => 'Eventos'],
            ['slug' => 'headline-news', 'title_en' => 'Headline News', 'title_es' => 'Titulares'],
            ['slug' => 'lifestyle',     'title_en' => 'Lifestyle',     'title_es' => 'Estilo de Vida'],
            ['slug' => 'home',          'title_en' => 'Home',          'title_es' => 'Inicio'],
            ['slug' => 'news',          'title_en' => 'News',          'title_es' => 'Noticias'],
            ['slug' => 'real-estate',   'title_en' => 'Real Estate',   'title_es' => 'Bienes Raíces'],
        ];

        foreach ($categories as $cat) {
            $defaultSectionSlug = $sectionDefaults[$cat['slug']] ?? null;
            $cat['section_id'] = $defaultSectionSlug ? ($sectionIds[$defaultSectionSlug] ?? null) : null;
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
