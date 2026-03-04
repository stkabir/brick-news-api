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
        $query = Article::with('category')
            ->orderByDesc('priority')
            ->orderByDesc('date');

        if ($request->has('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        return ArticleResource::collection($query->get());
    }

    public function show(string $slug)
    {
        $article = Article::with('category')->where('slug', $slug)->firstOrFail();
        return new ArticleResource($article);
    }
}
