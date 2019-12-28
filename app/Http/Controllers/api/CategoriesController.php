<?php

namespace App\Http\Controllers\api;

use App;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;

class CategoriesController extends Controller
{
    protected $catRepo;

    /**
     * CategoriesController constructor.
     */
    public function __construct()
    {
        $this->catRepo = App::make(CategoryRepository::class);
    }

    public function main()
    {
        return $this->catRepo->main();
    }

    public function child($id)
    {
        return $this->catRepo->child($id);
    }

    public function category($id)
    {
        return Category::findOrFail($id);
    }

    public function parent($id)
    {
        return $this->catRepo->parent($id);
    }
}
