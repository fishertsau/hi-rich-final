<?php

namespace App\Http\Controllers\admin;

use App\Models\Category\ProductCategory;

class ProductCategoriesController extends CategoriesBaseController 
{
    const AppliedFor = 'product';
    
    protected $appliedCategory = ProductCategory::class;

    protected $indexPageUri = '/admin/product/categories';

    protected function baseViewPath(){
        return 'system.' . self::AppliedFor;
    }
}
