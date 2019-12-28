<?php

namespace App\Http\Controllers\admin;

use App\Models\WebConfig;
use App\Http\Controllers\Controller;

class GearIntroController extends Controller
{
    public function edit()
    {
        return view('system.gearIntro.edit');
    }

    public function update()
    {
        WebConfig::firstOrCreate()
            ->update([
                'gear_intro' => request('gear_intro'),
                'gear_intro_en' => request('gear_intro_en')
            ]);

        return redirect('admin');
    }
}
