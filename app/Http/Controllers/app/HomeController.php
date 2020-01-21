<?php

namespace App\Http\Controllers\app;

use App;
use App\Models\Banner;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::orderByRanking()->published()->get();

        return view('app.home', compact('banners'));
    }
}