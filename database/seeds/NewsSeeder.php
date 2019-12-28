<?php

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        News::truncate();

        array_map(function () {
            $weeksBeforeFromNow = random_int(-10, -1);
            $weeksAfterFromNow = random_int(1, 3);

            factory(News::class)->create([
                'published_since' => \Carbon\Carbon::parse($weeksBeforeFromNow . ' weeks'),
                'published_until' => \Carbon\Carbon::parse($weeksAfterFromNow . ' weeks')
            ]);

        }, range(1, 30));
    }
}
