<?php

use App\Models\WebConfig;
use Illuminate\Database\Seeder;

class WebConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // TODO: Implement this
        $webConfig = [
            'address' => config('app.address'),
            'tel' => config('app.phone'),
            'email' => config('app.email'),
            'fax' => config('app.fax'),
            'title' => config('app.title'),
            'google_map' => config('app.address'),
            // todo: move to config/app.php
            'contact_ok' => '感謝您,我們會盡快與您聯絡',
            'inquiry_info' => '感謝您,我們會盡快與您聯絡',
            'category_photo_enabled' => config('app.category_photo_enabled'),
//            'category_description' => 'MainCategoryDescriptionMainCategoryDescriptionMainCategoryDescription',
            'declare' => config('app.declare'),
            'fb_url'=>'https://www.facebook.com/yungmin28627460',
        ];

        WebConfig::firstOrCreate()->update($webConfig);
    }
}
