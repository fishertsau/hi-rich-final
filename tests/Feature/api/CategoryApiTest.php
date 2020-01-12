<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Category\NewsCategory;
use App\Models\Category\ProductCategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryApiTest extends TestCase
{
    use DatabaseMigrations;

    function setUp()
    {
        parent::setUp();
        $this->actingAs(factory(User::class)->make());
    }

    /** @test */
    public function 可以取得指定Model的主類別()
    {
        factory(ProductCategory::class, 2)->create();
        factory(NewsCategory::class)->create();

        // 抓取 ProductCategory
        $response = $this->get('/api/categories/main/product');
        $response->assertSuccessful();
        $this->assertCount(2, $response->decodeResponseJson());

        // 抓取 NewsCategory 
        $response = $this->get('/api/categories/main/news');
        $response->assertSuccessful();
        $this->assertCount(1, $response->decodeResponseJson());
    }

    /** @test */
    public function 未指定正確Model的主類別會回傳錯誤()
    {
        $response = $this->get('/api/categories/main/non_existing_model');

        $response->assertStatus(404);
        $this->assertEquals('No correct applied model for category specified.', $response->getContent());
    }

    /** @test */
    public function 可以依照id抓取指定的類別()
    {
        $cat = factory(NewsCategory::class)->create(['title' => 'catTitle']);

        $response = $this->get('/api/categories/'.$cat->id);

        $response->assertSuccessful();
        $responseCat = json_decode($response->getContent());
        $this->assertEquals(1,$responseCat->id);
        $this->assertEquals('catTitle',$responseCat->title);
    }

    /** @test */
    public function 可抓取指定類別的直接子類別()
    {
        $cat = factory(NewsCategory::class)->create(['title' => 'catTitle']);
        factory(NewsCategory::class, 3)->create(['parent_id' => $cat->id]);

        $response = $this->get('/api/categories/'.$cat->id.'/children');

        $response->assertSuccessful();
        $this->assertCount(3, $response->decodeResponseJson());
    }

    /** @test */
    public function 可抓取指定類別的父類別()
    {
        $cat = factory(NewsCategory::class)->create(['title' => 'catTitle']);
        $subCat = factory(NewsCategory::class)->create(['parent_id' => $cat->id]);

        $response = $this->get('/api/categories/'.$subCat->id.'/parent');

        $response->assertSuccessful();
        
        $parentCat = json_decode($response->getContent());
        $this->assertEquals('catTitle', $parentCat->title);
    }
}
