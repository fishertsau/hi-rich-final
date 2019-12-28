<?php

use App\Models\Category;
use App\Models\Photo;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    private $photoList = [
        '1.jpg',
        '2.jpg',
        '3.jpg',
        '4.jpg',
        '5.jpg',
        '6.jpg',
        '7.jpg',
        '8.jpg',
        '9.jpg',
        '10.jpg',
    ];

    public function run()
    {
        Product::truncate();
        Photo::truncate();

        $categories = Category::all();

        $categories->each(function ($category) {
            if (!$category->hasDescendants) {
                collect(range(1, 3))->each(function () use ($category) {
                    $product =
                        factory(Product::class)
                            ->create([
                                'cat_id' => $category->id,
                                'photoPath' => $this->copyPhoto(),
                                'published_in_home' => false
                            ]);

                    collect(range(1, random_int(5, 8)))->each(function ($key) use ($product) {
                        $product->photos()->create(['photoPath' => $this->copyPhoto(), 'title' => 'photo title'.$key]);
                    });

                    $this->generateEnglishVersionContent($product);
                });
            }
        });

    }

    private function copyPhoto()
    {
        $newPhotoPath = config('filesystems.app.image_baseDir') . '/' . str_random(40) . '.jpg';
        $fileName = collect($this->photoList)->random();
        File::copy(base_path() . '/' . $this->productSourceImageDir() . $fileName,
            public_path(config('filesystems.app.public_storage_root')) . '/' . $newPhotoPath);

        return $newPhotoPath;
    }

    /**
     * @return string
     */
    private function productSourceImageDir(): string
    {
        return 'public/images/';
    }


    /**
     * @param Product $product
     */
    private function generateEnglishVersionContent(Product $product)
    {
        if (config('app.english_enabled')) {
            $product->update([
                'title_en' => $product->title . "_en",
                'briefing_en' => $product->briefing . "_en",
                'body_en' => $product->body . "_en",
            ]);
        }
    }
}
