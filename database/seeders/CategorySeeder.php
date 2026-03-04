<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['slug' => 'business',     'title_en' => 'Business',     'title_es' => 'Negocios'],
            ['slug' => 'events',       'title_en' => 'Events',       'title_es' => 'Eventos'],
            ['slug' => 'headline-news','title_en' => 'Headline News','title_es' => 'Titulares'],
            ['slug' => 'lifestyle',    'title_en' => 'Lifestyle',    'title_es' => 'Estilo de Vida'],
            ['slug' => 'home',         'title_en' => 'Home',         'title_es' => 'Inicio'],
            ['slug' => 'news',         'title_en' => 'News',         'title_es' => 'Noticias'],
            ['slug' => 'real-estate',  'title_en' => 'Real Estate',  'title_es' => 'Bienes Raíces'],
        ];

        foreach ($categories as $cat) {
            \App\Models\Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
