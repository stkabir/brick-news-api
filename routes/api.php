<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\SectionController;
use Illuminate\Support\Facades\Route;

Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{slug}', [ArticleController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/sections', [SectionController::class, 'index']);
Route::get('/search', SearchController::class);
