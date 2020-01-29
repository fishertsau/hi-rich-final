<?php

namespace App\Http\Controllers\admin;


use Illuminate\Database\Eloquent\Model;

trait PhotoHandler
{
    /**
     * @param Model $model
     * @param string $ctrl
     * @param string $attribute
     * @return PhotoHandler
     */
    private function storeCoverPhoto(Model $model, $ctrl = 'photoCtrl', $attribute = 'photoPath')
    {
        if (request($ctrl) === 'newFile') {
            $model->update([
                $attribute => $this->photoRepo->store(request()->file('photo'))
            ]);
        }

        return $this;
    }

    private function storePhoto(Model $model)
    {
        $this->storeCoverPhoto($model);
        return $this;
    }

    /**
     * @param $model
     * @param string $ctrl
     * @param string $attribute
     * @param string $fileInput
     * @param bool $resize
     * @return PhotoHandler
     */
    private function updatePhoto($model, $ctrl = 'photoCtrl', $attribute = 'photoPath', $fileInput = 'photo', $resize = true)
    {
        if (request($ctrl) === 'newFile') {
            $this->deleteFile($model->photoPath);
            $model->update([$attribute =>
                $this->photoRepo->store(request()->file($fileInput), $resize),
            ]);
        }

        if (request($ctrl) === 'deleteFile') {
            $this->deleteFile($model->photoPath);
            $model->update([$attribute => null]);
        }

        return $this;
    }

    private function deleteFile($path)
    {
        \File::delete(public_path('storage') . '/' . $path);
    }

    private function deletePhoto($filePath)
    {
        $this->deleteFile($filePath);
        return $this;
    }
}