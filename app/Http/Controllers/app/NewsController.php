<?php

namespace App\Http\Controllers\app;

use App;
use App\Models\News;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    public function index()
    {
        //TODO: Implement this : change this
        if (App::getLocale() === 'en') {
            $newss = News::wherePublished(true)
                ->withinEffective()
                //TODO: Implement this : cover this with test
                ->where('title_en', '<>', '')
                ->orderBy('published_since', 'desc')
                ->paginate(15);
        } else {
            $newss = News::wherePublished(true)
                ->withinEffective()
                //TODO: Implement this : cover this with test
                ->where('title', '<>', '')
                ->orderBy('published_since', 'desc')
                ->paginate(15);
        }

        return view('app.news.index', compact('newss'));
    }

    public function show($id)
    {
//        todo: change this
        $news = News::wherePublished(true)->where('id', $id)->first();

        return view('app.news.show');
    }
}
