<?php

namespace App\Http\Controllers\admin;

use App\Models\News;
use App\Http\Controllers\Controller;
use App\Models\Category\NewsCategory;

class NewsController extends Controller
{
    public function index()
    {
        $newss = News::latest()
            ->with('category')
            ->orderBy('cat_id')
            ->paginate(20);
        return view('system.news.index', compact('newss'));
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        $cats = NewsCategory::main()->get();
        return view('system.news.edit', compact('news', 'cats'));
    }

    public function create()
    {
        $cats = NewsCategory::main()->get();
        return view('system.news.edit', compact('cats'));
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

    public function copy(News $news)
    {
        $news->title .= '(複製)';
        $copyNews = true;

        $cats = NewsCategory::main()->get();

        return view('system.news.edit', compact('news', 'copyNews', 'cats'));
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

    private function validateInput()
    {
        return request()->validate([
            'cat_id' => 'required',
            'title' => 'required',
            'body' => '',
            'published' => 'required|boolean',
            'published_since' => '',
            'published_until' => '',
        ]);
    }

}