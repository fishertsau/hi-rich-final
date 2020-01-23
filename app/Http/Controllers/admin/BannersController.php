<?php

namespace App\Http\Controllers\admin;

use App\Models\Banner;
use App\Http\Controllers\Controller;
use App\Repositories\PhotoRepository;

class BannersController extends Controller
{
    use PhotoHandler;
    
    /**
     * @var PhotoRepository
     */
    private $photoRepo;

    /**
     * ProductsController constructor.
     * @param PhotoRepository $photoRepository
     */
    public function __construct(PhotoRepository $photoRepository)
    {
        $this->photoRepo = $photoRepository;
    }
    
    public function index()
    {
        $banners = Banner::orderByRanking()->get();
       
        return view('system.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('system.banners.edit');
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('system.banners.edit', compact('banner'));
    }

    public function store()
    {
        $input = $this->validateInput();
        $input['ranking'] = Banner::count() + 1;
        $banner = Banner::create($input);

        $this->storeCoverPhoto($banner);
        
        return redirect('admin/banners');
    }

    public function update(Banner $banner)
    {
        $banner->update($this->validateInput());

        $this->updatePhoto($banner);
        
        return redirect('admin/banners');
    }
    
    public function destroy(Banner $banner)
    {
        $banner->delete();

        return redirect('admin/banners');
    }

    public function ranking()
    {
        collect(request('id'))->each(function ($id, $key) {
            Banner::findOrFail($id)
                ->update(['ranking' => request('ranking')[$key]]);
        });

        return redirect('admin/banners');
    }

    private function validateInput()
    {
        return request()->validate([
            'title' => 'required',
            'published' => 'required|boolean'
        ]);
    }
}
