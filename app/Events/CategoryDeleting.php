<?php

namespace App\Events;

use App\Models\Category;

class CategoryDeleting
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
        $this->nullParentChildCategory()
            ->deleteCoverPhoto();
    }

    private function nullParentChildCategory()
    {
        $childCategories = $this->category->childCategories;

        $childCategories->each(function ($category) {
            $category->update(['parent_id' => null]);
        });

        return $this;
    }

    private function deleteCoverPhoto()
    {
        \File::delete(public_path('storage') . '/' . $this->category->photoPath);
    }
}
