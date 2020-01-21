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
        $webConfig = [
            // company info
            'company_name' => config('app.name'),
            'address' => config('app.address'),
            'tel' => config('app.phone'),
            'email' => config('app.email'),
            'fax' => config('app.fax'),
          
            // marketing info
            'slogan' => config('app.slogan'),
            'slogan_sub' => config('app.slogan_sub'),
            
            // page info
            'title' => config('app.title') 
        ];

        WebConfig::firstOrCreate()->update($webConfig);
    }
}
