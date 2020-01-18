<?php

namespace App\ViewComposers;

use App;
use Illuminate\View\View;
use App\Models\Category\ProductCategory;

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
        return ProductCategory::whereActivated(true)->main()->orderByRanking()->get();
    }
}