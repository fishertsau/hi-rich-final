<?php

namespace App\Events;

use App\Models\Product;

class ProductDeleting
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
        $this
            ->deleteCoverPhoto()
            ->deletePdfFile()
            ->deletePhotos();
    }


    private function deletePdfFile()
    {
        $this->deleteFile($this->product->pdfPath);
        return $this;
    }

    private function deleteCoverPhoto()
    {
        $this->deleteFile($this->product->photoPath);
        return $this;
    }

    private function deletePhotos()
    {
        $this->product->photos->each(function ($photo) {
            $this->deleteFile($photo->photoPath);
        });

        $this->product->photos()->delete();
    }

    private function deleteFile($path)
    {
        \File::delete(public_path('storage') . '/' . $path);
    }
}
