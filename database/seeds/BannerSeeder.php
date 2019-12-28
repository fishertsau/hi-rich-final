<?php

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // todo: remove this 
        return;
        Banner::truncate();

        $photoPathA = 'images/' . str_random(40) . '.jpg';
        File::copy(public_path('images/ban-1.jpg'),
            public_path('storage/' . $photoPathA));

        $photoPathB = 'images/' . str_random(40) . '.jpg';
        File::copy(public_path('images/ban-2.jpg'),
            public_path('storage/' . $photoPathB));

        Banner::firstOrCreate([
            'photoPath'=>$photoPathA
        ]);

        Banner::secondOrCreate([
            'photoPath'=>$photoPathB
        ]);
    }
}
