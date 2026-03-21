<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['slug' => 'business',      'title_en' => 'Business',      'title_es' => 'Negocios',        'section' => 'featured'],
            ['slug' => 'events',        'title_en' => 'Events',        'title_es' => 'Eventos',         'section' => 'trending'],
            ['slug' => 'headline-news', 'title_en' => 'Headline News', 'title_es' => 'Titulares',       'section' => 'top-stories'],
            ['slug' => 'lifestyle',     'title_en' => 'Lifestyle',     'title_es' => 'Estilo de Vida',  'section' => 'featured'],
            ['slug' => 'home',          'title_en' => 'Home',          'title_es' => 'Inicio',          'section' => null],
            ['slug' => 'news',          'title_en' => 'News',          'title_es' => 'Noticias',        'section' => 'top-stories'],
            ['slug' => 'real-estate',   'title_en' => 'Real Estate',   'title_es' => 'Bienes Raíces',   'section' => 'trending'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
