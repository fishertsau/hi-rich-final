<?php

use App\Models\Category\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
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
        ProductCategory::where('for', ProductCategory::getCatIndex())->delete();

        $mainCats = $this->createMainCatsWithTitles();

        $mainCats->each(function ($cat) use ($faker) {
            $subNum = random_int(5, 10);
            for ($i = 0; $i < $subNum; $i++) {
                $this->createChildCategory($cat, $faker);
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

    private function createMainCatsWithTitles()
    {
        return collect($this->mainCatTitles)->map(function ($title) {
            return factory(ProductCategory::class)->create([
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
