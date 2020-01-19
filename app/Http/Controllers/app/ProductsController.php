<?php

namespace App\Http\Controllers\app;

use App;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    public function index()
    {
        return view('app.products.index');
    }
}
