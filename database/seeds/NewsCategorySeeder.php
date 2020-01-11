<?php

use Illuminate\Database\Seeder;
use App\Models\Category\NewsCategory;

class NewsCategorySeeder extends Seeder
{
    private $mainCatTitles = [
        '產品訊息',
        '活動訊息',
        '公司訊息',
        '媒體訊息',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NewsCategory::where('for', NewsCategory::getCatIndex())->delete();

        collect($this->mainCatTitles)->each(function ($title) {
            factory(NewsCategory::class)->create([
                'title' => $title
            ]);
        });
    }
}
