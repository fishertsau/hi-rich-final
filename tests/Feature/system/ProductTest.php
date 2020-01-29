<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;

    function setUp()
    {
        parent::setUp();
        $this->actingAs(factory(User::class)->make());
    }

    /** @test */
    public function can_visit_list_page()
    {
        $response = $this->get('/admin/products');

        $response
            ->assertRedirect('admin/products/list');
    }

    /** @test */
    public function can_visit_create_page()
    {
        $response = $this->get('/admin/products/create');

        $response
            ->assertSuccessful()
            ->assertSee('產品上架管理')
            ->assertSee('新增產品');
    }


    /** @test */
    public function can_visit_edit_page()
    {
        $product = factory(Product::class)->create();
        $response = $this->get('/admin/products/' . $product->id . '/edit');

        $response->assertSuccessful()
            ->assertSee('產品上架管理')
            ->assertSee('修改產品')
            ->assertSee($product->title);
    }

    /** @test */
    public function can_create_a_new_product_from_admin()
    {
        $newProductInfo = [
            'published' => true,
            'cat_id' => 1,
            'title' => 'ANewProduct',
            'title_en' => 'ANewProductEnglish',
            'briefing' => 'ANewProductBriefing',
            'body' => 'SomeContent Body',
            'photoCtrl' => 'newFile',
            'photo' => UploadedFile::fake()->image('photo.jpg'),
            'pdfCtrl' => 'newPdfFile',
            'pdfFile' => UploadedFile::fake()->image('file.pdf'),
            'photos' => [
                UploadedFile::fake()->image('photoA.jpg'),
                UploadedFile::fake()->image('photoB.jpg'),
                'ThisIsNotAFile'
            ]
        ];

        $response = $this->post('admin/products', $newProductInfo);

        $this->assertCount(1, Product::all());

        $product = Product::first();
        $response->assertRedirect('admin/products');
        $this->assertEquals(true, $product->published);
        $this->assertEquals(1, $product->cat_id);
        $this->assertEquals('ANewProduct', $product->title);
        $this->assertEquals('ANewProductEnglish', $product->title_en);
        $this->assertEquals('ANewProductBriefing', $product->briefing);
        $this->assertEquals('SomeContent Body', $product->body);
        $this->assertNotNull($product->ranking);
        $this->assertSame(0, (int)$product->ranking);
        $this->assertNotNull($product->photoPath);
        $this->assertFileExists(public_path('storage/' . $product->photoPath));
        $this->assertNotNull($product->pdfPath);
        $this->assertFileExists(public_path('storage/' . $product->pdfPath));
        $this->assertCount(2, $product->photos);
    }

    /** @test */
    public function no_photo_or_pdf_file_is_created_if_no_newFile_command_is_given()
    {
        $newProductInfo = [
            'published' => true,
            'cat_id' => 1,
            'title' => 'ANewProduct',
            'body' => 'SomeContent Body',
            'photoCtrl' => '',
            'photo' => UploadedFile::fake()->create('photo.jpg'),
            'pdfCtrl' => '',
            'pdfFile' => UploadedFile::fake()->create('file.pdf')
        ];

        $response = $this->post('admin/products', $newProductInfo);

        $product = Product::first();
        $response->assertRedirect('admin/products');
        $this->assertNull($product->photoPath);
        $this->assertNull($product->pdfPath);
    }


    /** @test */
    public function can_update_an_existing_product_from_admin()
    {
        $product = factory(Product::class)->create();
        $newProductInfo = [
            'published' => true,
            'cat_id' => 3,
            'title' => 'ANewTitle',
            'title_en' => 'ANewTitleEnglish',
            'body' => 'SomeNewContent Body',
            'photoCtrl' => 'newFile',
            'photo' => UploadedFile::fake()->image('photo.jpg'),
            'pdfCtrl' => 'newPdfFile',
            'pdfFile' => UploadedFile::fake()->image('file.pdf'),
            'photos' => [
                UploadedFile::fake()->image('photoA.jpg'),
                UploadedFile::fake()->image('photoB.jpg'),
                'ThisIsNotFile'
            ]
        ];

        $response = $this->patch('/admin/products/' . $product->id, $newProductInfo);

        $product = $product->fresh();
        $response->assertRedirect('admin/products');
        $this->assertEquals(true, $product->published);
        $this->assertEquals(3, $product->cat_id);
        $this->assertEquals('ANewTitle', $product->title);
        $this->assertEquals('ANewTitleEnglish', $product->title_en);
        $this->assertEquals('SomeNewContent Body', $product->body);
        $this->assertEquals($product->ranking, (int)$product->ranking);
        $this->assertNotNull($product->photoPath);
        $this->assertFileExists(public_path('storage/' . $product->photoPath));
        $this->assertNotNull($product->pdfPath);
        $this->assertFileExists(public_path('storage/' . $product->pdfPath));
        $this->assertCount(2, $product->photos);


        //update again with a new photo
        $firstPhotoPath = $product->photoPath;
        $firstPdfPath = $product->pdfPath;

        $updatedProductInfo = [
            'published' => true,
            'cat_id' => 3,
            'title' => 'ANewTitle',
            'body' => 'SomeNewContent Body',
            'photoCtrl' => 'newFile',
            'photo' => UploadedFile::fake()->image('photo2.jpg'),
            'pdfCtrl' => 'newPdfFile',
            'pdfFile' => UploadedFile::fake()->image('file.pdf')
        ];
        $response = $this->patch('/admin/products/' . $product->id, $updatedProductInfo);

        $product = $product->fresh();
        $response->assertRedirect('admin/products');
        $this->assertNotNull($product->photoPath);
        $this->assertFileExists(public_path('storage/' . $product->photoPath));
        $this->assertFileNotExists(public_path('storage/' . $firstPhotoPath));
        $this->assertNotNull($product->pdfPath);
        $this->assertFileExists(public_path('storage/' . $product->pdfPath));
        $this->assertFileNotExists(public_path('storage/' . $firstPdfPath));

        //update again to delete photo
        $secondPhotoPath = $product->photoPath;
        $secondPdfPath = $product->pdfPath;
        $updatedProductInfo = [
            'published' => true,
            'cat_id' => 3,
            'title' => 'ANewTitle',
            'body' => 'SomeNewContent Body',
            'photoCtrl' => 'deleteFile',
            'photo' => UploadedFile::fake()->image('photo3.jpg'),
            'pdfCtrl' => 'deletePdfFile',
            'pdfFile' => UploadedFile::fake()->image('file.pdf')
        ];
        $response = $this->patch('/admin/products/' . $product->id, $updatedProductInfo);

        $product = $product->fresh();
        $response->assertRedirect('admin/products');
        $this->assertNull($product->photoPath);
        $this->assertFileNotExists(public_path('storage/' . $secondPhotoPath));
        $this->assertNull($product->pdfPath);
        $this->assertFileNotExists(public_path('storage/' . $secondPdfPath));
    }


    /** @test */
    public function can_copy_a_product_from_admin()
    {
        $product = factory(Product::class)->create();

        $response = $this->get('/admin/products/' . $product->id . '/copy');

        $response->assertSuccessful()
            ->assertSee('產品上架管理')
            ->assertSee('複製產品')
            ->assertSee($product->title)
            ->assertSee($product->body);
    }


    /** @test */
    public function can_update_ranking_from_admin()
    {
        $products = factory(Product::class, 3)->create();
        $rankingInput = [
            'id' => [$products[0]->id, $products[1]->id, $products[2]->id],
            'ranking' => [5, 4, 3]
        ];

        $response = $this->patch('/admin/products/ranking', $rankingInput);

        $response->assertRedirect('/admin/products');
        $this->assertEquals(5, $products[0]->fresh()->ranking);
        $this->assertEquals(4, $products[1]->fresh()->ranking);
        $this->assertEquals(3, $products[2]->fresh()->ranking);
    }


    /** @test */
    public function can_delete_many_products_at_one_time()
    {
        $products = factory(Product::class, 5)->create();
        $input = [
            'chosen_id' => [
                $products[0]->id,
                $products[2]->id,
                $products[4]->id],
            'action' => 'delete'
        ];

        $response = $this->patch('/admin/products/action', $input);

        $response->assertSuccessful();
        $this->assertNull($products[0]->fresh());
        $this->assertNotNull($products[1]->fresh());
        $this->assertNull($products[2]->fresh());
        $this->assertNotNull($products[3]->fresh());
        $this->assertNull($products[4]->fresh());
    }

    /** @test */
    public function can_delete_a_product()
    {
        
        $product = factory(Product::class)->create();

        $response = $this->delete('/admin/products/' . $product->id);

        $response->assertRedirect('/admin/products');
        $this->assertNull(Product::find($product->id));
    }


    /** @test */
    public function can_set_published_for_many_products_at_one_time()
    {
        $products = factory(Product::class, 3)->create(['published' => false]);
        $products->each(function ($product) {
            $this->assertFalse($product->published);
        });

        $input = [
            'chosen_id' => [
                $products[0]->id,
                $products[2]->id
            ],
            'action' => 'setToShow'
        ];

        $response = $this->patch('/admin/products/action', $input);

        $response->assertSuccessful();
        $this->assertTrue($products[0]->fresh()->published);
        $this->assertFalse($products[1]->fresh()->published);
        $this->assertTrue($products[2]->fresh()->published);
    }

    /** @test */
    public function can_set_noShow_for_many_products_at_one_time()
    {
        $products = factory(Product::class, 3)->create(['published' => true]);
        $products->each(function ($product) {
            $this->assertTrue($product->published);
        });
        $input = [
            'chosen_id' => [
                $products[0]->id,
                $products[2]->id
            ],
            'action' => 'setToNoShow'
        ];

        $response = $this->patch('/admin/products/action', $input);

        $response->assertSuccessful();
        $this->assertFalse($products[0]->fresh()->published);
        $this->assertTrue($products[1]->fresh()->published);
        $this->assertFalse($products[2]->fresh()->published);
    }

    /** @test */
    public function published_is_required_to_create_a_new_product()
    {
        $this->withExceptionHandling();
        $newProductInfo = [
            'cat_id' => 1,
            'title' => 'ANewProduct',
            'body' => 'SomeContent Body'
        ];

        $response = $this->post('admin/products', $newProductInfo);

        $this->assertValidationError($response, 'published');
    }

    /** @test */
    public function published_should_be_boolean_when_creating_a_product()
    {
        $this->withExceptionHandling();
        $newProductInfo = [
            'published' => 'published',
            'cat_id' => 1,
            'title' => 'ANewProduct',
            'body' => 'SomeContent Body'
        ];

        $response = $this->post('admin/products', $newProductInfo);

        $this->assertValidationError($response, 'published');
    }
    
    /** @test */
    public function published_is_required_to_update_a_product()
    {
        $this->withExceptionHandling();
        $product = factory(Product::class)->create();
        $newProductInfo = [
            'cat_id' => 1,
            'title' => 'ANewProduct',
            'body' => 'SomeContent Body'
        ];

        $response = $this->patch('/admin/products/' . $product->id, $newProductInfo);
        $this->assertValidationError($response, 'published');
    }

    /** @test */
    public function published_should_be_boolean_to_update_a_product()
    {
        $this->withExceptionHandling();
        $product = factory(Product::class)->create();

        $newProductInfo = [
            'published' => 'published',
            'cat_id' => 1,
            'title' => 'ANewProduct',
            'body' => 'SomeContent Body'
        ];

        $response = $this->patch('/admin/products/' . $product->id, $newProductInfo);

        $this->assertValidationError($response, 'published');
    }

    /** @test */
    public function can_visit_config_page_from_admin()
    {

        $response = $this->get('admin/products/config');

        $response->assertSuccessful()
            ->assertSee('前台筆數顯示設定')
            ->assertSee('編輯資料');
    }

    /** @test */
    public function can_query_products_and_send_new_query_term_from_admin()
    {
        $publishedProductQty = random_int(5, 10);

        factory(Product::class, $publishedProductQty)->states('published')->create([
            'title' => 'Super Product'
        ]);

        //arrange
        $queryTerm = [
            'newSearch' => 1,
            'published' => true,
            'keyword' => 'Keyword',
        ];

        //act
        $response = $this->post('/admin/products/list', $queryTerm);

        //assert
        $response->assertSuccessful();
        $this->assertArraySubset(array_except($queryTerm, ['newSearch']), session('queryTerm'));

        //act //only send page
        $response = $this->get('/admin/products/list' . '?page=1');
        $response->assertSuccessful();
        $this->assertArraySubset(array_except($queryTerm, ['newSearch']), session('queryTerm'));


        //send new search
        //arrange
        $queryTerm = [
            'newSearch' => 1,
            'published' => false,
            'keyword' => 'NewKeyWord',
        ];
        //act
        $response = $this->post('/admin/products/list', $queryTerm);

        //assert
        $response->assertSuccessful();
        $this->assertArraySubset(array_except($queryTerm, ['newSearch']), session('queryTerm'));
    }
}
