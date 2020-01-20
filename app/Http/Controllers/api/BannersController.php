<?php

namespace App\Http\Controllers\api;

use App\Models\Banner;
use App\Http\Controllers\Controller;

class BannersController extends Controller
{
    public function index()
    {
        return Banner::orderByRanking()->get();
    }
    
    public function publishedIndex()
    {
        return Banner::published()->orderByRanking()->get();
    }
}
