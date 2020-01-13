<?php

namespace App\Repositories;

use App;
use App\Models\Category;
use RuntimeException;

class CategoryRepository
{
    private $categoryList = [
        'product' => Category\ProductCategory::class,
        'news' => Category\NewsCategory::class,
        'link' => Category\LinkCategory::class
    ];

    public function main($appliedModel)
    {
        if (!isset($this->categoryList[$appliedModel])) {
            throw new RuntimeException('error');
        }

        return $this->categoryList[$appliedModel]::main()->get();
    }

    public function child($id)
    {
        return Category::findOrFail($id)->childCategories;
    }

    public function parent($id)
    {
        return Category::findOrFail($id)->parentCategory;
    }

    public function descendants($id)
    {
        return Category::findOrFail($id)->descendants;
    }

    public function getSelfOrDescendantsId($id)
    {
        $category = Category::findOrFail($id);

        return
            $category->hasDescendants
                ? $category->descendants->pluck('id')->toArray()
                : $id;
    }

    //TODO: Implement this : cover  this with test
    public function hasCategory(): bool
    {
        if (App::getLocale() == 'en') {
            return Category::where('title_en', '<>', '')->exists();
        }

        return Category::where('title', '<>', '')->exists();
    }
}