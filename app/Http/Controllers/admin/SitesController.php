<?php

namespace App\Http\Controllers\admin;

use App\Models\Site;
use App\Http\Controllers\Controller;

class SitesController extends Controller
{

    public function index()
    {
        // todo: by ranking
        $sites = Site::all();
        return view('system.sites.index', compact('sites'));
    }

    public function create()
    {
        return view('system.sites.edit');
    }

    public function edit($id)
    {
        $site = Site::findOrFail($id);
        return view('system.sites.edit', compact('site'));
    }

    public function store()
    {
        $input = $this->validateInput();
        $input['ranking'] = Site::count() + 1;
        Site::create($input);

        return redirect('admin/sites');
    }

    public function update(Site $site)
    {
        $site->update($this->validateInput());

        return redirect('admin/sites');
    }
    
    public function destroy(Site $site)
    {
        $site->delete();

        return redirect('admin/sites');
    }

    public function ranking()
    {
        collect(request('id'))->each(function ($id, $key) {
            Site::findOrFail($id)
                ->update(['ranking' => request('ranking')[$key]]);
        });

        return redirect('admin/sites');
    }

    private function validateInput()
    {
        return request()->validate([
            'name' => 'required',
            'published' => 'required|boolean',
            'address' => '',
            'tel' => '',
            'fax' => '',
            'email' => ''
        ]);
    }
}
