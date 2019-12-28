<?php

namespace App\Http\Controllers\admin;


use App\Models\About;
use App\Http\Controllers\Controller;

class AboutsController extends Controller
{
    public function index()
    {
        $abouts = About::orderByRanking()->paginate(20);

        return view('system.about.index', compact('abouts'));
    }

    public function edit($id)
    {
        $about = About::findOrFail($id);
        return view('system.about.edit', compact('about'));
    }

    public function create()
    {
        return view('system.about.create');
    }

    public function store()
    {
        About::create($this->validateInput());

        return redirect('admin/abouts');
    }

    public function update(About $about)
    {
        $about->update($this->validateInput());

        return redirect('admin/abouts');
    }

    private function validateInput()
    {
        return request()->validate([
            'title' => '',
            'title_en' => '',
            'published' => 'required|boolean',
            'body' => '',
            'body_en' => ''
        ]);
    }

    public function copy(About $about)
    {
        $about->title .= '(複製)';

        if (config('app.english_enabled')) {
            $about->title_en .= '(複製)';
        }

        return view('system.about.create', compact('about'));
    }


    public function ranking()
    {
        collect(request('id'))->each(function ($id, $key) {
            About::findOrFail($id)
                ->update(['ranking' => request('ranking')[$key]]);
        });

        return redirect('admin/abouts');
    }


    public function destroy(About $about)
    {
        $about->delete();

        return redirect('admin/abouts');
    }

    public function action()
    {
        if (request('action') === 'setToShow') {
            collect(request('chosen_id'))->each(function ($id) {
                About::findOrFail($id)
                    ->update(['published' => true]);
            });
        }

        if (request('action') === 'setToNoShow') {
            collect(request('chosen_id'))->each(function ($id) {
                About::findOrFail($id)
                    ->update(['published' => false]);
            });
        }

        if (request('action') === 'delete') {
            collect(request('chosen_id'))->each(function ($id, $key) {
                About::findOrFail($id)
                    ->delete();
            });
        }

        return response(200);
    }
}