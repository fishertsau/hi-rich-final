<?php

namespace App\Http\Controllers\admin;

use App\Models\Banner;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use App\Repositories\PhotoRepository;

class BannersController extends Controller
{
    private $photoRepo;

    /**
     * BannersController constructor.
     * @param $photoRepo
     */
    public function __construct(PhotoRepository $photoRepo)
    {
        $this->photoRepo = $photoRepo;
    }


    public function edit()
    {
        $bannerA = Banner::first();
        $bannerB = Banner::last();
        return view('system.banner.edit', compact('bannerA', 'bannerB'));
    }


    public function update()
    {
        $bannerA = Banner::firstOrCreate($this->getInput('titleA', 'subTitleA'));
        $this->handlePhoto($bannerA, request('bannerA_photoCtrl'), request()->file('photoA'), 'photoPath');
        $this->handlePhoto($bannerA, request('bannerA_photoEnCtrl'), request()->file('photoA_en'), 'photoPath_en');

        $bannerB = Banner::secondOrCreate($this->getInput('titleB', 'subTitleB'));
        $this->handlePhoto($bannerB, request('bannerB_photoCtrl'), request()->file('photoB'),'photoPath');
        $this->handlePhoto($bannerB, request('bannerB_photoEnCtrl'), request()->file('photoB_en'), 'photoPath_en');

        return redirect('/admin/banner');
    }

    /**
     * @internal param $bannerA
     * @param $banner
     * @param $photoControl
     * @param UploadedFile $photo
     * @param $field
     */
    private function handlePhoto($banner, $photoControl, UploadedFile $photo=null, $field)
    {
        switch ($photoControl) {
            case 'newFile':
                $this->deletePhoto($banner,$field);
                $photoPath = $this->photoRepo->store($photo,false);
                $this->updatePhotoPath($banner, $photoPath, $field);
                break;
            case 'deleteFile':
                $this->deletePhoto($banner,$field);
                $this->updatePhotoPath($banner, '', $field);
                break;
        }
    }

    /**
     * @param null $titleField
     * @param null $subTitleField
     * @return array
     */
    private function getInput($titleField = null, $subTitleField = null)
    {
        return [
            'title' => request($titleField),
            'subTitle' => request($subTitleField),
        ];
    }

    /**
     * @param $banner
     * @param $field
     */
    private function deletePhoto($banner,$field)
    {
        $oldPath = public_path('storage') . '/' . $banner->{$field};
        \File::delete($oldPath);
    }


    /**
     * @param Banner $banner
     * @param $newPath
     * @param $field
     */
    private function updatePhotoPath(Banner $banner, $newPath, $field)
    {
        $banner->update([$field => $newPath]);
    }
}