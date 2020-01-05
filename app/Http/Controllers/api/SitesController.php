<?php

namespace App\Http\Controllers\api;

use App\Models\Site;
use App\Http\Controllers\Controller;

class SitesController extends Controller
{
    public function index()
    {
        return Site::orderByRanking()->get();
    }

    public function publishedIndex()
    {
        return Site::published()->orderByRanking()->get();
    }
}
