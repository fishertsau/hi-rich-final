<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductApiTest extends TestCase
{
    use DatabaseMigrations;

    function setUp()
    {
        parent::setUp();
        $this->actingAs(factory(User::class)->make());
    }

    /** @test */
    public function can_get_product_which_are_set_to_see_in_app_home_page(){

        factory(Product::class)->states('published')
          ->times(3)->create(['published_in_home'=>true]);

      $response = $this->get('/admin/product/publishedInHome');

      $response->assertSuccessful();
      $this->assertCount(3,$response->decodeResponseJson());
    }
}
