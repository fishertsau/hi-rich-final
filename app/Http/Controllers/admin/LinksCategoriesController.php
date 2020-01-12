<?php

namespace App\Http\Controllers\admin;

use App\Models\Category\LinkCategory;

class LinksCategoriesController extends ProductCategoriesController 
{
    const AppliedFor = 'links';
    
    protected $appliedCategory = LinkCategory::class;

    protected $indexPageUri = '/admin/links/categories';

    protected function baseViewPath(){
        return 'system.' . self::AppliedFor;
    }
}
