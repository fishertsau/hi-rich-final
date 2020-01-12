<?php

namespace App\Http\Controllers\admin;

use App\Models\Link;
use App\Http\Controllers\Controller;
use App\Models\Category\LinkCategory;

class LinksController extends Controller
{
    public function index()
    {
        $links = Link::latest()->paginate(20);
        return view('system.links.index', compact('links'));
    }

    public function edit($id)
    {
        $link = Link::findOrFail($id);
        $cats = LinkCategory::main()->get();
        return view('system.links.edit', compact('link', 'cats'));
    }

    public function create()
    {
        $cats = LinkCategory::main()->get();
        return view('system.links.edit', compact('cats'));
    }

    public function store()
    {
        Link::create($this->validateInput());

        return redirect('admin/links');
    }

    public function update(Link $link)
    {
        $link->update($this->validateInput());

        return redirect('admin/links');
    }

    public function destroy(Link $link)
    {
        $link->delete();

        return redirect('admin/links');
    }

    public function action()
    {
        if (request('action') === 'setToShow') {
            collect(request('chosen_id'))->each(function ($id) {
                Link::findOrFail($id)
                    ->update(['published' => true]);
            });
        }

        if (request('action') === 'setToNoShow') {
            collect(request('chosen_id'))->each(function ($id) {
                Link::findOrFail($id)
                    ->update(['published' => false]);
            });
        }

        if (request('action') === 'delete') {
            collect(request('chosen_id'))->each(function ($id, $key) {
                Link::findOrFail($id)
                    ->delete();
            });
        }

        return response(200);
    }
    
    private function validateInput()
    {
        return request()->validate([
            'cat_id' =>  'required',
            'title' => 'required',
            'published' => 'required|boolean',
            'url' => ''
        ]);
    }
}