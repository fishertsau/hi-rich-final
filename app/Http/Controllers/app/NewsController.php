<?php

namespace App\Http\Controllers\app;

use App;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    public function index()
    {
        return view('app.news.index');
    }
}
