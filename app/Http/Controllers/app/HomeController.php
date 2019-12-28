<?php

namespace App\Http\Controllers\app;

use App;
use App\Models\News;
use App\Models\Banner;
use App\Models\Product;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // TODO: Implement this: change this
        //TODO: Implement this : cover this with test
//        if (App::getLocale() === 'en') {
//            $hotProducts = Product::wherePublished(true)
//                ->where('published_in_home', true)
//                ->where('title_en', '<>', '')
//                ->orderByRanking()->get();
//        } else {
//            $hotProducts = Product::wherePublished(true)
//                ->where('published_in_home', true)
//                ->where('title', '<>', '')
//                ->orderByRanking()->get();
//        }
//
//
//        //TODO: Implement this : cover this with test
//        if (App::getLocale() === 'en') {
//            $newss = News::wherePublished(true)
//                ->withinEffective()
//                //TODO: Implement this : cover this with test
//                ->where('title_en', '<>', '')
//                ->orderBy('published_since', 'desc')
//                ->take(4)
//                ->get();
//        } else {
//            $newss = News::wherePublished(true)
//                ->withinEffective()
//                //TODO: Implement this : cover this with test
//                ->where('title', '<>', '')
//                ->orderBy('published_since', 'desc')
//                ->take(4)
//                ->get();
//
//        }

//        $bannerA = Banner::first();
//        $bannerB = Banner::last();

        return view('app.home');
    }
}