<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Filterable\ProductFilter;
use App\Models\Category\ProductCategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductFilterTest extends TestCase
{
    use DatabaseMigrations;

    private $productFilter;

    /** @before */
    function setUpItem()
    {
        $this->productFilter = new ProductFilter();
    }


    /** @test */
    public function products_could_be_queried_with_keyword_for_title()
    {
        $productQtyWithTitle1 = random_int(1, 3);
        factory(Product::class, $productQtyWithTitle1)
            ->create([
                'title' => 'Super Title'
            ]);

        $productQtyWithTitle2 = random_int(1, 3);
        factory(Product::class, $productQtyWithTitle2)
            ->create([
                'title' => 'Great title'
            ]);

        $productQtyWithEnglishTitle = random_int(1, 3);
        factory(Product::class, $productQtyWithEnglishTitle)
            ->create([
                'title_en' => 'Super title'
            ]);

        //status
        //act + assert
        $queryResult = $this->productFilter->getList(['keyword' => 'Super']);
        $this->assertCount($productQtyWithTitle1 + $productQtyWithEnglishTitle,
            $queryResult);

        //act + assert
        $queryResult = $this->productFilter->getList(['keyword' => 'Great']);
        $this->assertCount($productQtyWithTitle2, $queryResult);
    }


    /** @test */
    public function products_could_be_queried_with_cat_id()
    {
        $category = factory(ProductCategory::class)->create();
        $subCategoryA = $category->childCategories()->create(['activated' => true, 'title' => 'subCategoryTitle',
            'description' => 'subCategoryDescription', 'level' => $category->level + 1
        ]);

        $subSubCategoryA_A = $subCategoryA->childCategories()->create(['activated' => true, 'title' => 'subCategoryTitle',
            'description' => 'subCategoryDescription', 'level' => $subCategoryA->level + 1
        ]);
        $subSubCategoryA_B = $subCategoryA->childCategories()->create(['activated' => true, 'title' => 'subCategoryTitle',
            'description' => 'subCategoryDescription', 'level' => $subCategoryA->level + 1
        ]);
        $subSubCategoryA_C = $subCategoryA->childCategories()->create(['activated' => true, 'title' => 'subCategoryTitle',
            'description' => 'subCategoryDescription', 'level' => $subCategoryA->level + 1
        ]);

        $subCategoryB = $category->childCategories()->create(['activated' => true, 'title' => 'subCategoryTitle',
            'description' => 'subCategoryDescription', 'level' => $category->level + 1
        ]);

        factory(Product::class, 2)->create(['cat_id' => $subSubCategoryA_A->id]);
        factory(Product::class, 2)->create(['cat_id' => $subSubCategoryA_B->id]);
        factory(Product::class, 2)->create(['cat_id' => $subSubCategoryA_C->id]);
        factory(Product::class, 2)->create(['cat_id' => $subCategoryB->id]);

        //act + assert
        $queryResult = $this->productFilter->getList([
            'cat_ids' => $category->descendants->pluck('id')]);
        $this->assertCount(8, $queryResult);

        $queryResult = $this->productFilter->getList([
            'cat_ids' => $subCategoryA->descendants->pluck('id')]);
        $this->assertCount(6, $queryResult);

        $queryResult = $this->productFilter->getList(['cat_ids' => $subSubCategoryA_C->id]);
        $this->assertCount(2, $queryResult);

        $queryResult = $this->productFilter->getList(['cat_ids' => $subCategoryB->id]);
        $this->assertCount(2, $queryResult);
    }


    /** @test */
    public function products_could_be_queried_with_publish_status()
    {
        $publishedProductQty = random_int(1, 10);
        factory(Product::class, $publishedProductQty)
            ->states('published')
            ->create();

        $unpublishedProductQty = random_int(1, 10);
        factory(Product::class, $unpublishedProductQty)
            ->states('unpublished')
            ->create();

        //status
        //act + assert
        $queryResult = $this->productFilter->getList(['published' => true]);
        $this->assertCount($publishedProductQty, $queryResult);

        //act + assert
        $queryResult = $this->productFilter->getList(['published' => false]);
        $this->assertCount($unpublishedProductQty, $queryResult);
    }


}