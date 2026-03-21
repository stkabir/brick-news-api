<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'slug'           => 'trending',
                'title_en'       => 'Trending Developments',
                'title_es'       => 'Desarrollos en Tendencia',
                'description_en' => 'The projects and deals shaping Brickell\'s skyline.',
                'description_es' => 'Los proyectos y acuerdos que moldean el horizonte de Brickell.',
                'section_layout' => 'grid',
                'categories'     => [],
                'order'          => 3,
            ],
            [
                'slug'           => 'top-stories',
                'title_en'       => 'Top Stories',
                'title_es'       => 'Noticias Principales',
                'description_en' => 'The most important stories from Brickell and Miami.',
                'description_es' => 'Las noticias más importantes de Brickell y Miami.',
                'section_layout' => 'list',
                'categories'     => [],
                'order'          => 1,
            ],
            [
                'slug'           => 'featured',
                'title_en'       => 'Featured',
                'title_es'       => 'Destacados',
                'description_en' => 'Curated stories from around the neighborhood.',
                'description_es' => 'Historias seleccionadas del vecindario.',
                'section_layout' => 'sidebar',
                'categories'     => [],
                'order'          => 2,
            ],
        ];

        foreach ($sections as $data) {
            Section::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
