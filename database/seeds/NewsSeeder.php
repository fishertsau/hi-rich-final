<?php

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        News::truncate();

        $newsCatIds = \App\Models\Category\NewsCategory::main()->get()->pluck('id')->toArray();

        $maxId = max($newsCatIds);
        $minId = min($newsCatIds);

        foreach (range(1, 30) as $value) {
            $weeksBeforeFromNow = random_int(-10, -1);
            $weeksAfterFromNow = random_int(1, 3);

            factory(News::class)->create([
                'cat_id' => random_int($minId, $maxId),
                'published_since' => \Carbon\Carbon::parse($weeksBeforeFromNow . ' weeks'),
                'published_until' => \Carbon\Carbon::parse($weeksAfterFromNow . ' weeks')
            ]);
        }
    }
}
