<?php

namespace App\Models\Category;

use App\Models\Category;

class LinkCategory extends Category
{
    protected $table = 'categories';
    
    const FOR = '連結類別';

    public static function  getCatIndex()
    {
        return self::CatIndexList[self::FOR];
    }
}
