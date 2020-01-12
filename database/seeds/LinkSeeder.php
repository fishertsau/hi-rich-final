<?php

use App\Models\Link;
use Illuminate\Database\Seeder;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        Link::truncate();

        $newsCatIds = \App\Models\Category\LinkCategory::main()->get()->pluck('id')->toArray();

        $maxId = max($newsCatIds);
        $minId = min($newsCatIds);

        foreach (range(1, 30) as $value) {
            factory(Link::class)->create([
                'cat_id' => random_int($minId, $maxId),
            ]);
        }
    }
}
