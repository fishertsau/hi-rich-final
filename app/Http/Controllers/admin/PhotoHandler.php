<?php
namespace App\Http\Controllers\admin;


use Illuminate\Database\Eloquent\Model;

trait PhotoHandler
{
    /**
     * @param Model $model
     * @return PhotoHandler
     */
    private function storeCoverPhoto(Model $model)
    {
        if (request('photoCtrl') === 'newFile') {
            $model->update([
                'photoPath' => $this->photoRepo->store(request()->file('photo'))
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
     * @return PhotoHandler
     */
    private function updatePhoto($model)
    {
        if (request('photoCtrl') === 'newFile') {
            $this->deleteFile($model->photoPath);
            $model->update(['photoPath' =>
                $this->photoRepo->store(request()->file('photo')),
            ]);
        }

        if (request('photoCtrl') === 'deleteFile') {
            $this->deleteFile($model->photoPath);
            $model->update(['photoPath' => null]);
        }

        return $this;
    }

    private function deleteFile($path)
    {
        \File::delete(public_path('storage') . '/' . $path);
    }
}