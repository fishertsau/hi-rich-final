<?php

namespace Tests\Unit;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function all_subCategories_parentCategory_becomes_null_when_a_category_is_deleted()
    {
        $category = factory(Category::class)->create(['title' => 'categoryTitle']);
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
        $category = factory(Category::class)->create();
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

        $category = factory(Category::class)->create(['title' => 'MainCategory']);
        $subCategory = factory(Category::class)->create(['title' => 'SubCategory', 'parent_id' => $category->id]);
        $subSubCategory = factory(Category::class)->create(['title' => 'SubSubCategory', 'parent_id' => $subCategory->id]);

        $this->assertEquals('MainCategory/SubCategory/SubSubCategory', $subSubCategory->seriesTitles);
    }

    /** @test */
    public function can_know_if_has_descendants_or_not()
    {
        $category = factory(Category::class)->create();
        $this->assertFalse($category->fresh()->hasDescendants);

        factory(Category::class)->create(['parent_id' => $category->id]);
        $this->assertTrue($category->fresh()->hasDescendants);
    }


    /** @test */
    public function cover_photo_is_deleted_when_category_is_deleted()
    {
        $category =
            factory(Category::class)
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
        $catA = create(Category::class);
        $catB = create(Category::class);
        $catC = create(Category::class, ['level' => 2]);

        $catIds = Category::main()->get()->pluck('id');

        $this->assertContains($catA->id, $catIds);
        $this->assertContains($catB->id, $catIds);
        $this->assertNotContains($catC->id, $catIds);
    }
}
