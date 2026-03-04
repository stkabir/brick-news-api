<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $q = trim($request->get('q', ''));

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $articles = Article::with('category')
            ->where(function ($query) use ($q) {
                $query->where('title_en', 'like', "%{$q}%")
                    ->orWhere('title_es', 'like', "%{$q}%")
                    ->orWhere('summary_en', 'like', "%{$q}%")
                    ->orWhere('summary_es', 'like', "%{$q}%")
                    ->orWhere('author', 'like', "%{$q}%");
            })
            ->orderByDesc('priority')
            ->orderByDesc('date')
            ->limit(6)
            ->get();

        return response()->json($articles->map(fn ($a) => [
            'id'         => $a->id,
            'slug'       => $a->slug,
            'titleEn'    => $a->title_en,
            'titleEs'    => $a->title_es,
            'summaryEn'  => $a->summary_en,
            'summaryEs'  => $a->summary_es,
            'image'      => $a->image,
            'category'   => $a->category?->slug,
            'categoryEn' => $a->category?->title_en,
            'categoryEs' => $a->category?->title_es,
            'author'     => $a->author,
            'date'       => $a->date?->toDateString(),
        ]));
    }
}
