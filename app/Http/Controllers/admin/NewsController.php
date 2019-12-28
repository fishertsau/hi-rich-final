<?php

namespace App\Http\Controllers\admin;

use App\Models\News;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    public function index()
    {
        $newss = News::latest()->paginate(20);
        return view('system.news.index', compact('newss'));
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('system.news.edit', compact('news'));
    }

    public function create()
    {
        return view('system.news.edit');
    }

    public function store()
    {
        News::create($this->validateInput());

        return redirect('admin/news');
    }

    public function update(News $news)
    {
        $news->update($this->validateInput());

        return redirect('admin/news');
    }

    private function validateInput()
    {
        return request()->validate([
            'title' => '',
            'title_en' => '',
            'body' => '',
            'body_en' => '',
            'published' => 'required|boolean',
            'published_since' => '',
            'published_until' => '',
        ]);
    }

    public function copy(News $news)
    {
        $news->title .= '(複製)';
        $copyNews = true;

        if(config('app.english_enabled')){
            $news->title_en .= '(複製)';
        }

        return view('system.news.edit', compact('news', 'copyNews'));
    }


    public function ranking()
    {
        collect(request('id'))->each(function ($id, $key) {
            News::findOrFail($id)
                ->update(['ranking' => request('ranking')[$key]]);
        });

        return redirect('admin/news');
    }


    public function destroy(News $news)
    {
        $news->delete();

        return redirect('admin/news');
    }

    public function action()
    {
        if (request('action') === 'setToShow') {
            collect(request('chosen_id'))->each(function ($id) {
                News::findOrFail($id)
                    ->update(['published' => true]);
            });
        }

        if (request('action') === 'setToNoShow') {
            collect(request('chosen_id'))->each(function ($id) {
                News::findOrFail($id)
                    ->update(['published' => false]);
            });
        }

        if (request('action') === 'delete') {
            collect(request('chosen_id'))->each(function ($id, $key) {
                News::findOrFail($id)
                    ->delete();
            });
        }

        return response(200);
    }
}