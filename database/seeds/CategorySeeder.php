<?php

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    private $photoList = [
        'product01.jpg',
        'product02.jpg',
        'product03.jpg',
        'product04.jpg',
        'product05.jpg',
    ];

    private $mainCatTitles = [
        '蝦類',
        '貝類',
        '魚類',
        '軟體類',
        '甲殼類',
    ];

    /**
     * Run the database seeds.
     *
     * @param \Faker\Generator $faker
     * @return void
     */
    public function run(Faker\Generator $faker)
    {
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
     * @return
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

        return $cat;
    }


    private function copyPhoto()
    {
        $photoPath = str_random(40) . '.jpg';
        $fileName = collect($this->photoList)->random();

        $targetOriginFile = public_path($this->photoBaseDir() . '/' . $fileName);
        $targetDestFile = public_path(
            config('filesystems.app.public_storage_root') . '/images/' . $photoPath);

        File::copy($targetOriginFile, $targetDestFile);

        return 'images/' . $photoPath;
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
                'photoPath' => $this->copyPhoto()
            ]);
        });
    }

    /**
     * @return string
     */
    private function photoBaseDir(): string
    {
        return config('filesystems.app.origin_products_image_baseDir');
    }
}
