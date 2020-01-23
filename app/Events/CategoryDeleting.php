<?php

namespace App\Events;

use App\Models\Category;

class CategoryDeleting extends CoverPhotoDeleting
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
        parent::__construct($category);
        $this->nullParentChildCategory();
    }

    private function nullParentChildCategory()
    {
        $childCategories = $this->category->childCategories;

        $childCategories->each(function ($category) {
            $category->update(['parent_id' => null]);
        });

        return $this;
    }
}
