<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use App\Models\WebConfig;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_visit_category_index_page()
    {
        $categoryA = create(Category::class, ['parent_id' => null, 'activated' => true]);
        $categoryB = create(Category::class, ['parent_id' => null, 'activated' => true]);
        $categoryC = create(Category::class, ['parent_id' => null, 'activated' => false]);
        $categoryD = create(Category::class, ['level' => 2, 'activated' => true]);

        $response = $this->get('categories');

        $response->assertViewIs('app.categories.index');

        tap($response->getOriginalContent()['categories']->pluck('id'),
            function ($categoryIds) use ($categoryA, $categoryB, $categoryC, $categoryD) {
                $this->assertContains($categoryA->id, $categoryIds);
                $this->assertContains($categoryB->id, $categoryIds);
                $this->assertNotContains($categoryC->id, $categoryIds);
                $this->assertNotContains($categoryD->id, $categoryIds);
            });
    }


    /** @test */
    public function can_see_all_activated_sub_categories_when_category_photo_enabled()
    {
        create(WebConfig::class, ['category_photo_enabled' => true]);

        $cat = create(Category::class, ['parent_id' => null, 'activated' => true]);
        $subCatA = create(Category::class, ['parent_id' => $cat->id, 'level' => 2, 'activated' => true]);
        $subCatB = create(Category::class, ['parent_id' => $cat->id, 'level' => 2, 'activated' => true]);
        $subCatC = create(Category::class, ['parent_id' => $cat->id, 'level' => 2, 'activated' => false]);
        $subCatD = create(Category::class, ['parent_id' => $cat->id + 1, 'level' => 2, 'activated' => true]);

        $response = $this->get('categories/' . $cat->id);

        $response->assertViewIs('app.categories.index');
        $response->assertViewHas('category', function ($viewCategory) use ($cat) {
            return $viewCategory->id === $cat->id;
        });

        tap($response->getOriginalContent()['categories']->pluck('id'),
            function ($categoryIds) use ($subCatA, $subCatB, $subCatC, $subCatD) {
                $this->assertContains($subCatA->id, $categoryIds);
                $this->assertContains($subCatB->id, $categoryIds);
                $this->assertNotContains($subCatC->id, $categoryIds);
                $this->assertNotContains($subCatD->id, $categoryIds);
            });
    }


    /** @test */
    public function redirect_to_products_by_category_if_no_activated_sub_categories()
    {
        create(WebConfig::class);
        $cat = create(Category::class, ['parent_id' => null, 'activated' => true]);

        $response = $this->get('categories/' . $cat->id);

        $response->assertRedirect('/products/category/' . $cat->id);
    }


    /** @test */
    public function can_see_all_activated_products_belonging_a_category_and_subCategories_when_category_photo_enabled_is_false()
    {
        create(WebConfig::class, ['category_photo_enabled' => false]);
        //main category
        $mainCategory = create(Category::class);

        //sub and subsub categories
        $subCategoryA = create(Category::class, ['parent_id' => $mainCategory->id]);
        $subSubCategoryA1 = create(Category::class, ['parent_id' => $subCategoryA->id]);

        //visit main category
        $response = $this->get("/categories/{$mainCategory->id}");
        $response->assertRedirect("/products/category/{$mainCategory->id}");

        //visit subCategoryA
        $response = $this->get("/categories/{$subCategoryA->id}");
        $response->assertRedirect("/products/category/{$subCategoryA->id}");

        //visit subSubCategoryA1
        $response = $this->get("/categories/{$subSubCategoryA1->id}");
        $response->assertRedirect("/products/category/{$subSubCategoryA1->id}");
    }
}
