<?php

use App\Models\Site;
use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
{
   
    private $siteList = [
        [
            'name' => '台北總公司',
            'address' => '新北市五股區五工一路131號5樓',
            'tel' => '02-22901180',
            'fax' => '02-22901070',
            'ranking' => 1,
            'email' => 'hi.rich@msa.hinet.net'
        ],
        [
            'name' => '高雄營業所',
            'address' => '高雄市前鎮區漁港東二路3號327室',
            'tel' => '07-8154925',
            'fax' => '07-81555430',
            'ranking' => 2,
            'email' => null
        ],
        [
            'name' => '台中營業所',
            'address' => '台中市西屯區大河街77號5樓',
            'tel' => '04-23158593',
            'fax' => '04-23158541',
            'ranking' => 3,
            'email' => null
        ]
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Site::truncate();

        foreach($this->siteList as $site) {
            factory(Site::class)->create($site);
        }
    }
}
