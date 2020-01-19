<?php

use App\Models\Photo;
use App\Models\Product;
use Illuminate\Database\Seeder;
use App\Models\Category\ProductCategory;

class ProductSeeder extends Seeder
{
    private $photoList = [
        'product01.jpg',
        'product02.jpg',
        'product03.jpg',
        'product04.jpg',
        'product05.jpg',
    ];

    public function run()
    {
        Product::truncate();
        Photo::truncate();

        $categories = ProductCategory::getActivatedByLevel(2);

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
                        $product->photos()->create(['photoPath' => $this->copyPhoto(), 'title' => 'photo title' . $key]);
                    });
                });
            }
        });
    }

    private function copyPhoto()
    {
        $newPhotoPath = str_random(40) . '.jpg';
        $fileName = collect($this->photoList)->random();

        $targetOriginFile = public_path(config('filesystems.app.origin_products_image_baseDir') . '/' . $fileName);
        $targetDestFile = public_path(
            config('filesystems.app.public_storage_root') . '/images/' . $newPhotoPath);

        File::copy($targetOriginFile, $targetDestFile);

        return 'images/' . $newPhotoPath;
    }
}
