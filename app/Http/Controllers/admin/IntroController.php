<?php

namespace App\Http\Controllers\admin;

use App\Models\WebConfig;
use App\Http\Controllers\Controller;

class IntroController extends Controller
{
    public function edit()
    {
        return view('system.intro.edit');
    }

    public function update()
    {
        WebConfig::firstOrCreate()
            ->update([
                'intro_title' => request('intro_title'),
                'intro_subTitle' => request('intro_subTitle'),
                'intro' => request('intro'),
                'intro_en' => request('intro_en'),
            ]);

        return redirect('admin');
    }
}
