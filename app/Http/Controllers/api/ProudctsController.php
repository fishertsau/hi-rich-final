<?php

namespace App\Http\Controllers\api;

use App\Models\Product;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    public function index()
    {
        return Product::published()
            ->where('title', '<>', '')
            ->orderByRanking()
            ->get();
    }
}
