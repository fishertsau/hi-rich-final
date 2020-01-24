<?php

namespace App\Http\Controllers\api;

use App\Models\Ad;
use App\Http\Controllers\Controller;

class AdsController extends Controller
{
    public function index()
    {
        return Ad::orderByLocation()->orderByRanking()->get();
    }
    
    public function publishedIndex()
    {
        return Ad::published()->orderByRanking()->get();
    }
}
