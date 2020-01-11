<?php

namespace App\Models\Category;

use App\Models\Category;

class ProductCategory extends Category
{
    protected $table = 'categories';
    
    const FOR = '產品類別';

    public static function  getCatIndex()
    {
        return self::CatIndexList[self::FOR];
    }
}
