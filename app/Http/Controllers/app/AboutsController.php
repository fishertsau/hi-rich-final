<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;

class AboutsController extends Controller
{
    public function index()
    {
        // TODO: Implement this: get the content from backend
        
        return view('app.abouts.index');
    }
}
