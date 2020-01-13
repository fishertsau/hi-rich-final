<?php

namespace App\Http\Controllers\api;

use App\Models\Link;
use App\Http\Controllers\Controller;

class LinksController extends Controller
{
    public function index()
    {
        return Link::published()->get();
    }
}
