<?php

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    private $photoList = [
        'a1.jpg',
        'a2.jpg',
        'a3.jpg',
        'a4.jpg',
        'a5.jpg',
        'a6.jpg',
        'a7.jpg',
        'a8.jpg',
        'a9.jpg',
    ];

    private $mainCatTitles = [
        '景觀圍牆大門',
        '景觀圍牆小門',
        '玄關門',
        '樓梯扶手',
        '藝術造型窗',
        '造型欄杆',
        '採光罩',
        '屏風牆飾壁飾',
        '鍛鐵製品',
    ];

    /**
     * Run the database seeds.
     *
     * @param \Faker\Generator $faker
     * @return void
     */
    public function run(Faker\Generator $faker)
    {
        // todo: remove this
        return;
        Category::truncate();

        $mainCats = $this->createMainCats();

        if (!config('app.3tier_category_enabled')) {
            return;
        }

        $mainCats->each(function ($cat) use ($faker) {
            $subNum = random_int(0, 3);

            for ($i = 0; $i < $subNum; $i++) {
                $subCat = $this->createChildCategory($cat, $faker);

                $subSubNum = random_int(0, 3);
                for ($j = 0; $j < $subSubNum; $j++) {
                    $this->createChildCategory($subCat, $faker);
                }
            }
        });
    }

    /**
     * @param $subCat
     * @param $faker
     */
    function createChildCategory($subCat, $faker)
    {
        $cat = $subCat->childCategories()->create([
            'title' => $faker->name,
            'activated' => true,
            'description' => $faker->sentence,
            'level' => $subCat->level + 1,
            'photoPath' => $this->copyPhoto(),
        ]);

        $this->generateEnglishVersionContent($cat);

        return $cat;
    }


    private function copyPhoto()
    {
        $photoPath = $this->photoBaseDir() . str_random(40) . '.jpg';
        $fileName = collect($this->photoList)->random();
        File::copy(public_path($this->photoBaseDir() . $fileName),
            public_path('storage/' . $photoPath));

        return $photoPath;
    }

    private function createMainCats()
    {
        if ($this->hasMainCatTitle()) {
            return $this->createMainCatWithTitles();
        }

        return factory(Category::class, 3)
            ->create(['photoPath' => $this->copyPhoto()]);
    }

    /**
     * @return bool
     */
    private function hasMainCatTitle(): bool
    {
        return collect($this->mainCatTitles)->count() > 0;
    }

    private function createMainCatWithTitles()
    {
        return collect($this->mainCatTitles)->map(function ($title) {
            return factory(Category::class)->create([
                'title' => $title,
                'title_en' => "{$title}_en",
                'photoPath' => $this->copyPhoto()
            ]);
        });
    }

    /**
     * @param Product $product
     */
    private function generateEnglishVersionContent(Model $cat)
    {
        if (config('app.english_enabled')) {
            $cat->update([
                'title_en' => $cat->title . "_en",
                'description_en' => $cat->description . "_en",
            ]);
        }
    }


    /**
     * @return string
     */
    private function photoBaseDir(): string
    {
        return 'images/';
    }
}
