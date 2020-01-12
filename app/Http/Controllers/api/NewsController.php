<?php

namespace App\Http\Controllers\api;

use App\Models\News;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    public function index()
    {
        return News::wherePublished(true)
            ->withinEffective()
            ->orderBy('published_since', 'desc')
            ->get();
    }
}
