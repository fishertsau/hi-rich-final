<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\WebConfig;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function see_products_lists_if_cat_is_not_enabled_when_product_index_visited()
    {
        create(WebConfig::class, ['category_photo_enabled' => false]);

        //content assertion arrangement
        $productA = factory(Product::class)->states('published')->create();
        $productB = factory(Product::class)->states('published')->create();
        $productC = factory(Product::class)->states('unpublished')->create();

        $response = $this->get('products');

        $response->assertSuccessful();

        tap($response->getOriginalContent()['products']->pluck('id'), function ($products) use ($productA, $productB, $productC) {
            $this->assertContains($productA->id, $products);
            $this->assertContains($productB->id, $products);
            $this->assertNotContains($productC->id, $products);
        });
    }

    /** @test */
    public function redirect_to_category_index_if_cat_is_enabled_when_products_index_visited()
    {
        create(WebConfig::class, ['category_photo_enabled' => true]);

        $response = $this->get('products');

        $response->assertRedirect('/categories');
    }


    /** @test */
    public function can_visit_product_detail_page()
    {
        $product = factory(Product::class)
            ->create(['title' => 'ProductTitle']);

        $response = $this->get('/products/' . $product->id);

        $response->assertSuccessful();
        $response->assertSee($product->title);
        $response->assertSee($product->body);
        $response->assertSee($product->briefing);
    }


    /** @test */
    public function can_see_product_list_by_category()
    {
        $category = create(Category::class);
        $productA = create(Product::class, ['published' => true, 'cat_id' => $category->id]);
        $productB = create(Product::class, ['published' => true, 'cat_id' => $category->id]);
        $productC = create(Product::class, ['published' => false, 'cat_id' => $category->id]);
        $productD = create(Product::class, ['published' => true, 'cat_id' => $category->id + 1]);

        $response = $this->get('/products/category/' . $category->id);

        $response->assertViewIs('app.products.index');
        $response->assertSee($category->description);
        tap($response->getOriginalContent()['products']->pluck('id'),
            function ($productIds) use ($productA, $productB, $productC, $productD) {
                $this->assertContains($productA->id, $productIds);
                $this->assertContains($productB->id, $productIds);
                $this->assertNotContains($productC->id, $productIds);
                $this->assertNotContains($productD->id, $productIds);
            });
    }


    /** @test */
    public function can_see_all_activated_products_belonging_a_category_and_subCategories()
    {
        //main category
        $mainCategory = create(Category::class);

        //sub and subsub categories
        $subCategoryA = create(Category::class, ['parent_id' => $mainCategory->id]);
        $subSubCategoryA1 = create(Category::class, ['parent_id' => $subCategoryA->id]);
        $subSubCategoryA2 = create(Category::class, ['parent_id' => $subCategoryA->id]);
        //products
        $productA1 = create(Product::class, ['published' => true, 'cat_id' => $subSubCategoryA1->id]);
        $productA2_published = create(Product::class, ['published' => true, 'cat_id' => $subSubCategoryA2->id]);
        $productA2_unpublished = create(Product::class, ['published' => false, 'cat_id' => $subSubCategoryA2->id]);

        //sub and subsub categories
        $subCategoryB = create(Category::class, ['parent_id' => $mainCategory->id]);
        $subCategoryB1 = create(Category::class, ['parent_id' => $subCategoryB->id]);
        $subCategoryB2 = create(Category::class, ['parent_id' => $subCategoryB->id]);
        $productB1 = create(Product::class, ['published' => true, 'cat_id' => $subCategoryB1->id]);
        $productB2_published = create(Product::class, ['published' => true, 'cat_id' => $subCategoryB2->id]);
        $productB2_unpublished = create(Product::class, ['published' => false, 'cat_id' => $subCategoryB2->id]);


        //visit main category
        $response = $this->get("/products/category/{$mainCategory->id}");

        $response->assertViewIs('app.products.index');
        $response->assertSee($mainCategory->description);
        $response->assertViewHas('category', function ($viewCategory) use ($mainCategory) {
            return $viewCategory->id === $mainCategory->id;
        });
        $response->assertViewHas('products', function ($viewProducts) {
            return $viewProducts->count() === 4;
        });
        tap($response->getOriginalContent()['products']->pluck('id'),
            function ($productIds) use (
                $productA1, $productA2_published, $productA2_unpublished,
                $productB1, $productB2_published, $productB2_unpublished
            ) {
                $this->assertContains($productA1->id, $productIds);
                $this->assertContains($productA2_published->id, $productIds);
                $this->assertNotContains($productA2_unpublished->id, $productIds);
                $this->assertContains($productB1->id, $productIds);
                $this->assertContains($productB2_published->id, $productIds);
                $this->assertNotContains($productB2_unpublished->id, $productIds);
            });

        //visit subCategoryA
        $response = $this->get("/products/category/{$subCategoryA->id}");

        $response->assertViewIs('app.products.index');
        $response->assertViewHas('category', function ($viewCategory) use ($subCategoryA) {
            return $viewCategory->id === $subCategoryA->id;
        });
        $response->assertViewHas('products', function ($viewProducts) {
            return $viewProducts->count() === 2;
        });
        tap($response->getOriginalContent()['products']->pluck('id'),
            function ($productIds) use (
                $productA1, $productA2_published, $productA2_unpublished,
                $productB1, $productB2_published, $productB2_unpublished
            ) {
                $this->assertContains($productA1->id, $productIds);
                $this->assertContains($productA2_published->id, $productIds);
                $this->assertNotContains($productA2_unpublished->id, $productIds);
                $this->assertNotContains($productB1->id, $productIds);
                $this->assertNotContains($productB2_published->id, $productIds);
                $this->assertNotContains($productB2_unpublished->id, $productIds);
            });

        //visit subSubCategoryA2
        $response = $this->get("/products/category/{$subSubCategoryA2->id}");

        $response->assertViewIs('app.products.index');
        $response->assertViewHas('category', function ($viewCategory) use ($subSubCategoryA2) {
            return $viewCategory->id === $subSubCategoryA2->id;
        });
        $response->assertViewHas('products', function ($viewProducts) {
            return $viewProducts->count() === 1;
        });
        tap($response->getOriginalContent()['products']->pluck('id'),
            function ($productIds) use (
                $productA1, $productA2_published, $productA2_unpublished,
                $productB1, $productB2_published, $productB2_unpublished
            ) {
                $this->assertNotContains($productA1->id, $productIds);
                $this->assertContains($productA2_published->id, $productIds);
                $this->assertNotContains($productA2_unpublished->id, $productIds);
                $this->assertNotContains($productB1->id, $productIds);
                $this->assertNotContains($productB2_published->id, $productIds);
                $this->assertNotContains($productB2_unpublished->id, $productIds);
            });
    }
}
