<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with(['category.section', 'section'])
            ->orderByDesc('priority')
            ->orderByDesc('date');

        if ($request->has('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        if ($request->has('section')) {
            $query->whereHas('section', fn ($q) => $q->where('slug', $request->section));
        }

        return ArticleResource::collection($query->get());
    }

    public function show(string $slug)
    {
        $article = Article::with(['category.section', 'section'])->where('slug', $slug)->firstOrFail();
        return new ArticleResource($article);
    }
}
