<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use App\Models\Category\ProductCategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function should_see_the_list_ordered_by_ranking()
    {
        for ($i = 0; $i < 10; $i++) {
            factory(Product::class)->create([
                'ranking' => random_int(0, 10)
            ]);
        }

        $products = Product::orderByRanking()->paginate(10);

        $products->each(function ($thisProduct, $index) use ($products) {
            if ($index < ($products->count() - 1)) {
                $nextProduct = $products[$index];

                $this->assertGreaterThanOrEqual(
                    $thisProduct->ranking, $nextProduct->ranking);
            }
        });
    }


    /** @test */
    public function can_see_all_it_category_and_descendant_string()
    {
        $category = factory(ProductCategory::class)->create(['title' => 'MainCategory']);
        $subCategory = factory(ProductCategory::class)->create(['title' => 'SubCategory', 'parent_id' => $category->id]);
        $subSubCategory = factory(ProductCategory::class)->create(['title' => 'SubSubCategory', 'parent_id' => $subCategory->id]);

        $product = factory(Product::class)->create(['title' => 'A Super Product', 'cat_id' => $subSubCategory->id]);

        $this->assertEquals('MainCategory/SubCategory/SubSubCategory', $product->catSeriesTitles);
    }


    /** @test */
    public function can_get_the_category_it_belongs_to()
    {
        $category = factory(ProductCategory::class)->create();
        $product = factory(Product::class)->create(['cat_id' => $category->id]);

        $this->assertEquals($category->id, $product->category->id);
    }


    /** @test */
    public function can_get_same_cat_products_and_index_previous_next_product()
    {
        $proA = factory(Product::class)
            ->states('published')->create(['cat_id' => 1, 'ranking' => 3]);
        $proB = factory(Product::class)
            ->states('published')->create(['cat_id' => 1, 'ranking' => 2]);
        $proC = factory(Product::class)
            ->states('published')->create(['cat_id' => 2]);
        $proD = factory(Product::class)
            ->states('unpublished')->create(['cat_id' => 1]);
        $proE = factory(Product::class)
            ->states('published')->create(['cat_id' => 1, 'ranking' => 1]);

        $products = $proA->productsByCat($proA->cat_id);

        $this->assertTrue($products->contains($proA));
        $this->assertTrue($products->contains($proB));
        $this->assertFalse($products->contains($proC));
        $this->assertFalse($products->contains($proD));
        $this->assertTrue($products->contains($proE));


        //can get the index for each product by ranking
        $this->assertEquals(3, $proA->index);
        $this->assertEquals(2, $proB->index);
        $this->assertEquals(1, $proC->index);


        //can get the next published product
        $this->assertEquals($proA->next_published->id, $proA->id);
        $this->assertEquals($proB->next_published->id, $proA->id);
        $this->assertEquals($proE->next_published->id, $proB->id);


        //can get the previous published product
        $this->assertEquals($proA->previous_published->id, $proB->id);
        $this->assertEquals($proB->previous_published->id, $proE->id);
        $this->assertEquals($proE->previous_published->id, $proE->id);
    }

    /** @test */
    public function cover_photo_photos_and_pdf_file_are_deleted_when_product_is_deleted()
    {
        $product = factory(Product::class)->create([
            'photoPath' => UploadedFile::fake()->create('photo.jpg')->store('images', 'public'),
            'pdfPath' => UploadedFile::fake()->create('file.pdf')->store('pdf', 'public'),
        ]);
        $photoA = $product->photos()->create([
            'photoPath' => UploadedFile::fake()->create('photo.jpg')->store('images', 'public')
        ]);
        $photoB = $product->photos()->create([
            'photoPath' => UploadedFile::fake()->create('photo.jpg')->store('images', 'public')
        ]);

        $productCoverPhoto = $product->fresh()->photoPath;
        $productPdfFile = $product->fresh()->pdfPath;

        $this->assertFileExists(public_path('storage/' . $productCoverPhoto));
        $this->assertFileExists(public_path('storage/' . $productPdfFile));
        $this->assertCount(2,$product->photos);
        $this->assertFileExists(public_path('storage/' . $photoA->photoPath));
        $this->assertFileExists(public_path('storage/' . $photoB->photoPath));


        $product->delete();

        $this->assertNull($product->fresh());
        $this->assertFileNotExists(public_path('storage/' . $productCoverPhoto));
        $this->assertFileNotExists(public_path('storage/' . $productPdfFile));
        $this->assertFileNotExists(public_path('storage/' . $photoA->photoPath));
        $this->assertFileNotExists(public_path('storage/' . $photoB->photoPath));
        $this->assertNull($photoA->fresh());
        $this->assertNull($photoB->fresh());
    }
}