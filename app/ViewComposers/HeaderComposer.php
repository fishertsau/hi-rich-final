<?php

namespace App\ViewComposers;

use App;
use App\Models\About;
use App\Models\Product;
use App\Models\Service;
use App\Models\Category;
use Illuminate\View\View;

class HeaderComposer
{
    // TODO: Implement this: remove this?????
    public function compose(View $view)
    {
        $view->with('categories', $this->getMainActivatedCategories());

        $view->with('headerAbouts', $this->getActivatedAbouts());

        $view->with('headerServices', $this->getActivatedServices());

        $view->with('publishedProducts', $this->getActivatedProducts());
    }

    //TODO: Implement this : cover this with test

    /**
     * @return mixed
     */
    private function getMainActivatedCategories()
    {
        if (App::getLocale() == 'en') {
            return Category::whereActivated(true)->whereLevel(1)->where('title_en', '<>', '')->orderByRanking()->get();
        }

        return Category::whereActivated(true)->whereLevel(1)->where('title', '<>', '')->orderByRanking()->get();
    }

    //TODO: Implement this : cover this with test

    /**
     * @return mixed
     */
    private function getActivatedAbouts()
    {
        if (App::getLocale() === 'en') {
            return About::wherePublished(true)->where('title_en', '<>', '')->orderByRanking()->get();
        }

        return About::wherePublished(true)->where('title', '<>', '')->orderByRanking()->get();
    }


    //TODO: Implement this : cover this with test

    /**
     * @return mixed
     */
    private function getActivatedServices()
    {
        if (App::getLocale() === 'en') {
            return Service::wherePublished(true)->where('title_en', '<>', '')->orderByRanking()->get();
        }

        return Service::wherePublished(true)->where('title', '<>', '')->orderByRanking()->get();
    }


    //TODO: Implement this : cover this with test

    /**
     * @return mixed
     */
    private function getActivatedProducts()
    {
        if (App::getLocale() === 'en') {
            return Product::wherePublished(true)->where('title_en', '<>', '')->orderByRanking()->get();
        }

        return Product::wherePublished(true)->where('title', '<>', '')->orderByRanking()->get();
    }
}