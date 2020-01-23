<?php

namespace App\Events;

use App\Photoable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\admin\PhotoHandler;

class ProductDeleting extends CoverPhotoDeleting
{
    use PhotoHandler;

    public function __construct(Model $model)
    {
        parent::__construct($model);
        $this->deletePdfFile($model->pdfFile);
        $this->deletePhotos($model);
    }

    private function deletePdfFile($filePath)
    {
        $this->deleteFile($filePath);
        
        return $this;
    }

    private function deletePhotos(Photoable $photoable)
    {
        $photoable->photos->each(function ($photo) {
            \File::delete(public_path('storage') . '/' . $photo->photoPath);
        });

        $photoable->photos()->delete();
    }
}
