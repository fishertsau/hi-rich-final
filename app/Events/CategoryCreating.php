<?php

namespace App\Events;

use App\Models\Category;

class CategoryCreating
{
    public function __construct(Category $category)
    {
        $category->for = $category->getCatIndex(); 
    }
}
