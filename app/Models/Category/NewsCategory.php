<?php

namespace App\Models\Category;

use App\Models\Category;

class NewsCategory extends Category 
{
    protected $table = 'categories';

    const FOR = '消息類別';

    public static function  getCatIndex()
    {
        return self::CatIndexList[self::FOR];
    }
}
