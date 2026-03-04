<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SectionResource;
use App\Models\Section;

class SectionController extends Controller
{
    public function index()
    {
        return SectionResource::collection(Section::orderBy('order')->get());
    }
}
