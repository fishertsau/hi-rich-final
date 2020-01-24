<?php

namespace App\Http\Controllers\app;

use App;
use App\Models\Ad;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Ad::where('location', Ad::LOCATION_BANNER)->orderByRanking()->published()->get();
        $products = Ad::where('location', Ad::LOCATION_HOME_PAGE)->orderByRanking()->published()->get();
        $activity = Ad::where('location', Ad::LOCATION_HOME_ACTIVITY)->orderByRanking()->published()->first();

        return view('app.home', compact('banners','activity', 'products'));
    }
}