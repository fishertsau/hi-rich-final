<?php

namespace App\ViewComposers;

use App;
use App\Models\Category;
use Illuminate\View\View;

class HeaderComposer
{
    public function compose(View $view)
    {
        $view->with('categories', $this->getMainActivatedCategories());
    }

    /**
     * @return mixed
     */
    private function getMainActivatedCategories()
    {
        return Category::whereActivated(true)->whereLevel(1)->where('title', '<>', '')->orderByRanking()->get();
    }
}