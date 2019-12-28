<?php

namespace App\Http\Controllers\app;

use App;
use App\Models\Category;
use App\Models\WebConfig;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::main()->where('activated', true)->get();

        return view('app.categories.index', compact('categories'));
    }


    public function show($catId)
    {
        if (!WebConfig::first()->category_photo_enabled) {
            return redirect("/products/category/{$catId}");
        }

        list($category, $childCategories) =
            $this->getCategoryAndChildCategories($catId);

        if (!$this->hasItems($childCategories)) {
            return $this->showProductsBelongToTheCategory($catId);
        }

        return view('app.categories.index')
            ->with([
                'category' => $category,
                'categories' => $childCategories
            ]);
    }

    /**
     * @param $categories
     * @return bool
     */
    private function hasItems($items): bool
    {
        return $items->count() > 0;
    }

    /**
     * @param $category
     * @return mixed
     */
    private function getActivatedChildCategories($category)
    {
        //TODO: Implement this : restore this
//        if (App::getLocale() == 'en') {
//            return $category->childCategories()
//                ->where('title_en', '<>', '')
//                ->where('activated', true)->get();
//        }

        return $category->childCategories()
            //TODO: Implement this : restore this
//            ->where('title', '<>', '')
            ->where('activated', true)->get();
    }

    /**
     * @param $catId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    private function showProductsBelongToTheCategory($catId)
    {
        return redirect('/products/category/' . $catId);
    }

    /**
     * @param $catId
     * @return array
     */
    private function getCategoryAndChildCategories($catId): array
    {
        $category = Category::findOrFail($catId);

        $categories = $this->getActivatedChildCategories($category);

        return array($category, $categories);
    }
}
