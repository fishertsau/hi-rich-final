<?php

namespace App\Repositories;

use Image;
use App\Models\Photo;
use Illuminate\Http\UploadedFile;


class PhotoRepository
{
    public function update($filename,$newAttribute)
    {
        $path = $this->generatePhotoPath($filename);

        $this->getPhotoByPhotoPath($path)
            ->update($newAttribute);

        return true;
    }

    public function delete($filename)
    {
        $path = $this->generatePhotoPath($filename);

        $this->deletePhotoFile($path);

        $this->deletePhotoModel($path);
    }


    public function store(UploadedFile $uploadedFile, $resize = true)
    {
        $photoPath = $uploadedFile->store($this->imageBaseDir(), 'public');

        //TODO: Implement this : cover this with test
        if ($resize) {
            $this->resizeImgCanvas($photoPath);
        }

        return $photoPath;
    }


    public function deletePhotoFile($photoPath)
    {
        $fullPath = $this->publicStorageRoot() . '/' . $photoPath;

        \File::delete($fullPath);
    }

    /**
     * @return mixed
     */
    private function imageBaseDir()
    {
        return config('filesystems.app.image_baseDir');
    }

    /**
     * @return string
     */
    private function publicStorageRoot(): string
    {
        return public_path(config('filesystems.app.public_storage_root'));
    }

    /**
     * @return string
     */
    public function generateImagesDir(): string
    {
        return $this->publicStorageRoot() . '/' . $this->imageBaseDir();
    }

    /**
     * @param $path
     */
    private function deletePhotoModel($path)
    {
        $this->getPhotoByPhotoPath($path)->delete();
    }

    /**
     * @param $filename
     * @return string
     */
    private function generatePhotoPath($filename): string
    {
        return $this->imageBaseDir() . '/' . $filename;
    }

    /**
     * @param $photoPath
     */
    public function resizeImgCanvas($photoPath)
    {
        $img = Image::make(public_path('storage') . '/' . $photoPath);

        $w = $img->getWidth();
        $h = $img->getHeight();

        $Wn = $w / 4;
        $Hn = $h / 3;

        if ($Wn > $Hn) {
            $img->resizeCanvas(null, round($Wn * 3), 'center', false);
        }

        if ($Wn < $Hn) {
            $img->resizeCanvas(round($Hn * 4), null, 'center', false);
        }

        $img->save();
    }

    /**
     * @param $path
     * @return mixed
     */
    private function getPhotoByPhotoPath($path)
    {
        return Photo::where('photoPath', $path)
            ->first();
    }
}