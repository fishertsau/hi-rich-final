<?php

namespace App\Http\Controllers\app;

use App;
use App\Models\Product;
use App\Models\Category;
use App\Models\WebConfig;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;

class ProductsController extends Controller
{
    /**
     * @var CategoryRepository
     */
    private $catRepo;

    /**
     * ProductsController constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->catRepo = $categoryRepository;
    }

    public function show($id)
    {
        // TODO: Implement this
        $product = Product::findOrFail($id);
        return view('app.products.show', compact('product'));
    }

    public function index()
    {
        $products =
            Product::published()
                ->where('title', '<>', '')
                ->orderByRanking()
                ->paginate(WebConfig::firstOrCreate()->product_show_per_page);

        return view('app.products.index', compact('products'));
    }
}
