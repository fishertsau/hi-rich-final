<?php

namespace App\Models\Category;

use App\Models\Category;

class ProductCategory extends Category
{
    protected $table = 'categories';

    const FOR = '產品類別';

    public static function getCatIndex()
    {
        return self::CatIndexList[self::FOR];
    }

    public static function getActivatedByLevel($level = 1)
    {
        return self::where('for', self::CatIndexList[self::FOR])
            ->where('level', $level)
            ->activated()->get();
    }
}
