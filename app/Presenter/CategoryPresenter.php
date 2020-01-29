<?php

namespace App\Presenter;


use App;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class CategoryPresenter
{
    public function ancestorsString(Category $category)
    {
        $string = $category->title;

        if ($category->parentCategory) {
            $string = $this->ancestorsString($category->parentCategory) . '/' . $string;
        }

        return $string;
    }

    public function pageTitle(Category $category = null)
    {
        if ($category) {
            return '修改分類';
        }

        return '新增分類';
    }

    public function listByCategory(Category $category = null, $sequence = 0, $forProduct = false)
    {
        if (!$category) {
            return '';
        }

        $title = $category->title;

        if ($this->middleNodeOrForProduct($sequence, $forProduct)) {
            $listString = "
                <li><a href='/products/category/{$category->id}'>{$title}</a></li>";
        } else {
            $listString =
                "<li>{$title}</li>";
        }

        return $category->parentCategory ? $this->listByCategory($category->parentCategory, ++$sequence) . $listString : $listString;
    }


    public function catType($category = null, $parent = null)
    {
        if ($category) {
            $level = $category->level;
        }

        if (!$category) {
            if ($parent) {
                $level = $parent->level + 1;
            }

            if (!$parent) {
                $level = null;
            }
        }

        switch ($level) {
            case 1:
                return '父分類';
            case 2:
                return '次分類';
            case 3:
                return '次次分類';
            default:
                return '父分類';
        }
    }


    public function givenCatId($category = null, $parent = null)
    {
        if (!$category && !$parent) {
            return null;
        }


        if ($category) {
            $parent = $category->parentCategory;

            if (!$parent) {
                return null;
            }

            if ($category->level === 3) {
                $grandPa = $parent->parentCategory;
                if (!$grandPa) {
                    return null;
                }
            }

            return $parent->id;
        }

        return $parent->id;
    }


    public function selectionLevel($category = null, $parent = null)
    {
        if (!$category && !$parent) {
            return 0;
        }

        if ($category) {
            return ($category->level - 1);
        }

        return $parent->level;
    }

    public function childCatForView(Category $category)
    {
        $categories = $category->childCategories;

        if (App::getLocale() === 'en') {
            return
                $categories->filter(function ($item) {
                    return $item->title_en <> '' && $item->activated === true;
                })->sortBy('ranking');
        }

        return
            $categories->filter(function ($item) {
                return $item->title <> '' && $item->activated === true;
            })->sortBy('ranking');
    }


    public function lang(Model $entry, string $field)
    {
        return $entry->$field;
    }

    /**
     * @param $sequence
     * @param $forProduct
     * @return bool
     */
    private function middleNodeOrForProduct($sequence, $forProduct): bool
    {
        return $sequence > 0 || $forProduct;
    }
}