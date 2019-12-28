<?php

namespace App\Http\Controllers\app;

use App;
use App\Models\News;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    public function index()
    {
        $newss = News::wherePublished(true)
            ->withinEffective()
            //TODO: Implement this : cover this with test
            ->where('title', '<>', '')
            ->orderBy('published_since', 'desc')
            ->paginate(15);

        return view('app.news.index', compact('newss'));
    }

    public function show($id)
    {
        $news = News::wherePublished(true)->where('id', $id)->first();

        return view('app.news.show', compact('news'));
    }
}
