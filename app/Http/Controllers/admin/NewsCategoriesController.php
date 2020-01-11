<?php

namespace App\Http\Controllers\admin;

use App\Models\Category\NewsCategory;

class NewsCategoriesController extends ProductCategoriesController 
{
    const AppliedFor = 'news';
    
    protected $appliedCategory = NewsCategory::class;

    protected $indexPageUri = '/admin/news/categories';

    protected function baseViewPath(){
        return 'system.' . self::AppliedFor;
    }
}
