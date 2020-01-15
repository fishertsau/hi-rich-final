<?php

namespace App\Http\Controllers\app;

use App\Models\About;
use App\Http\Controllers\Controller;

class AboutsController extends Controller
{
    public function index()
    {
        $abouts = About::orderByRanking()->published()->get();
        return view('app.abouts.index', compact('abouts'));
    }
}
