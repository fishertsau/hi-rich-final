<?php

namespace App\Http\Controllers\app;

use App;
use App\Http\Controllers\Controller;

class LinksController extends Controller
{
    /**
     * ProductsController constructor.
     */
    public function __construct()
    {
    }


    public function index()
    {
        return view('app.links.index');
    }
}
