<?php

namespace App\Http\Controllers\admin;

use App\Models\Ad;
use App\Http\Controllers\Controller;
use App\Repositories\PhotoRepository;

class AdsController extends Controller
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
        return view('system.ads.index');
    }

    public function create()
    {
        $locations = Ad::LOCATIONS;
        return view('system.ads.edit', compact('locations'));
    }

    public function edit($id)
    {
        $ad = Ad::findOrFail($id);
        $locations = Ad::LOCATIONS;
        return view('system.ads.edit', compact('ad', 'locations'));
    }

    public function store()
    {
        $input = $this->validateInput();
        $input['ranking'] = Ad::count() + 1;
        $ad = Ad::create($input);

        $this->storeCoverPhoto($ad, 'photoCtrl', 'photoPath', false);

        return redirect('admin/ads');
    }

    public function update(Ad $ad)
    {
        $ad->update($this->validateInput());

        $this->updatePhoto($ad, 'photoCtrl', 'photoPath', 'photo', false);

        return redirect('admin/ads');
    }

    public function destroy(Ad $ad)
    {
        $ad->delete();

        return redirect('admin/ads');
    }

    public function ranking()
    {
        collect(request('id'))->each(function ($id, $key) {
            Ad::findOrFail($id)
                ->update(['ranking' => request('ranking')[$key]]);
        });

        return redirect('admin/ads');
    }

    private function validateInput()
    {
        return request()->validate([
            'title' => 'required',
            'location' => 'required',
            'published' => 'required|boolean'
        ]);
    }
}
