<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Models\Category\NewsCategory;
use App\Models\Category\ProductCategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductCategoryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function all_subCategories_parentCategory_becomes_null_when_a_category_is_deleted()
    {
        $category = factory(ProductCategory::class)->create(['title' => 'categoryTitle']);
        $subCategory = $category->childCategories()->create([
            'activated' => true,
            'title' => 'subCategoryTitle',
            'description' => 'subCategoryDescription',
            'level' => $category->level + 1
        ]);

        $subSubCategory = $subCategory->childCategories()->create([
            'parent_id' => $subCategory->id,
            'activated' => true,
            'title' => 'subSubCategoryTitle',
            'description' => 'subSubCategoryDescription',
            'level' => $subCategory->level + 1
        ]);

        $category->delete();

        $this->assertNull($category->fresh());
        $this->assertNotNull($subCategory->fresh());
        $this->assertEquals(2, $subCategory->fresh()->level);
        $this->assertNull($subCategory->parentCategory);

        $this->assertNotNull($subSubCategory->fresh());
        $this->assertEquals(3, $subSubCategory->fresh()->level);
        $this->assertEquals($subCategory->id, $subSubCategory->parentCategory->id);
    }


    /** @test */
    public function can_know_the_category_level()
    {
        $category = factory(ProductCategory::class)->create();
        $subCategory = $category->childCategories()->create([
            'activated' => true,
            'title' => 'subCategoryTitle',
            'description' => 'subCategoryDescription',
            'level' => $category->level + 1
        ]);

        $subSubCategory = $subCategory->childCategories()->create([
            'activated' => true,
            'title' => 'subCategoryTitle',
            'description' => 'subCategoryDescription',
            'level' => $subCategory->level + 1
        ]);

        $this->assertEquals(1, $category->level);
        $this->assertEquals(2, $subCategory->level);
        $this->assertEquals(3, $subSubCategory->level);
    }

    /** @test */
    public function can_get_full_series_categories_title_string()
    {

        $category = factory(ProductCategory::class)->create(['title' => 'MainCategory']);
        $subCategory = factory(ProductCategory::class)->create(['title' => 'SubCategory', 'parent_id' => $category->id]);
        $subSubCategory = factory(ProductCategory::class)->create(['title' => 'SubSubCategory', 'parent_id' => $subCategory->id]);

        $this->assertEquals('MainCategory/SubCategory/SubSubCategory', $subSubCategory->seriesTitles);
    }

    /** @test */
    public function can_know_if_has_descendants_or_not()
    {
        $category = factory(ProductCategory::class)->create();
        $this->assertFalse($category->fresh()->hasDescendants);

        factory(ProductCategory::class)->create(['parent_id' => $category->id]);
        $this->assertTrue($category->fresh()->hasDescendants);
    }


    /** @test */
    public function cover_photo_is_deleted_when_category_is_deleted()
    {
        $category =
            factory(ProductCategory::class)
                ->create([
                    'photoPath' => UploadedFile::fake()->create('photo.jpg')->store('images', 'public'),
                ]);
        $coverPhoto = $category->fresh()->photoPath;
        $this->assertFileExists(public_path('storage/' . $coverPhoto));

        $category->delete();

        $this->assertNull($category->fresh());

        $this->assertFileNotExists(public_path('storage/' . $coverPhoto));
    }

    /** @test */
    public function can_get_the_main_category()
    {
        $catA = create(ProductCategory::class);
        $catB = create(ProductCategory::class);
        $catC = create(ProductCategory::class, ['level' => 2]);
        create(NewsCategory::class);

        $catIds = ProductCategory::main()->get()->pluck('id');

        $this->assertCount(2, $catIds);
        $this->assertContains($catA->id, $catIds);
        $this->assertContains($catB->id, $catIds);
        $this->assertNotContains($catC->id, $catIds);
    }
}
