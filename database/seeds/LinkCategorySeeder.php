<?php

use Illuminate\Database\Seeder;
use App\Models\Category\LinkCategory;

class LinkCategorySeeder extends Seeder
{
    private $mainCatTitles = [
        '配合廠商',
        '異業結盟',
        '政府/政策',
        '其他連結',
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LinkCategory::where('for', LinkCategory::getCatIndex())->delete();

        collect($this->mainCatTitles)->each(function ($title) {
            factory(LinkCategory::class)->create([
                'title' => $title
            ]);
        });
    }
}
