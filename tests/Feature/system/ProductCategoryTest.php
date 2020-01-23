<?php

namespace Tests\Feature\system;

use App\User;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Models\Category\ProductCategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductCategoryTest extends TestCase
{
    use DatabaseMigrations;

    function setUp()
    {
        parent::setUp();
        $this->actingAs(factory(User::class)->make());
    }

    /** @test */
    public function can_visit_category_list_page_from_admin()
    {
        $response = $this->get('/admin/product/categories');

        $response->assertSuccessful()
            ->assertSee('產品分類管理');
    }

    /** @test */
    public function can_visit_category_create_page()
    {
        $response = $this->get('/admin/product/categories/create');

        $response->assertSuccessful()
            ->assertSee('新增分類');
    }

    /** @test */
    public function can_visit_category_create_page_when_mainCat_is_given()
    {
        $category = factory(ProductCategory::class)->create();

        $response = $this->get('/admin/product/categories/create?parentId=' . $category->id);

        $response->assertSuccessful()
            ->assertSee('新增分類');
    }

    /** @test */
    public function can_visit_category_create_page_when_subCat_is_given()
    {
        $category = factory(ProductCategory::class)->create();
        $subCategory = $category->childCategories()->create([
            'activated' => true,
            'title' => 'subCategoryTitle',
            'description' => 'subCategoryDescription',
            'level' => $category->level + 1
        ]);

        $response = $this->get('/admin/product/categories/create?parentId=' . $subCategory->id);

        $response->assertSuccessful()
            ->assertSee('新增分類')
            ->assertSee('次次分類');
    }

    /** @test */
    public function can_create_1stTier_category_from_admin()
    {
        $input = [
            'parent_id' => null,
            'activated' => true,
            'title' => 'CategoryTitle',
            'title_en' => 'EnglishCategoryTitle',
            'description' => 'CategoryDescription',
            'description_en' => 'EnglishCategoryDescription',
            'photoCtrl' => 'newFile',
            'photo' => UploadedFile::fake()->image('photo.jpg'),
        ];

        $response = $this->post('/admin/product/categories', $input);

        $response->assertRedirect('/admin/product/categories');

        $category = ProductCategory::firstCat();
        $this->assertTrue($category->activated);
        $this->assertEquals('p', $category->for);
        $this->assertEquals('CategoryTitle', $category->title);
        $this->assertEquals('CategoryDescription', $category->description);
        $this->assertNotNull($category->ranking);
        $this->assertEquals(0, $category->ranking);
        $this->assertEquals(1, $category->level);
        $this->assertNotNull($category->photoPath);
        $this->assertFileExists(public_path('storage/' . $category->photoPath));

        //parent category and child category
        $this->assertNull($category->parentCategory);
        $this->assertCount(0, $category->childCategories);
    }

    /** @test */
    public function when_creating_firstTier_category_no_photo_is_created_if_no_newFile_command_is_given()
    {
        $input = [
            'activated' => true,
            'title' => 'CategoryTitle',
            'description' => 'CategoryDescription',
            'photoCtrl' => '',
            'photo' => UploadedFile::fake()->create('photo.jpg'),
        ];

        $response = $this->post('/admin/product/categories', $input);
        $category = ProductCategory::firstCat();
        $response->assertRedirect('/admin/product/categories');
        $this->assertNull($category->photoPath);
    }

    /** @test */
    public function can_create_2ndTier_category_from_admin()
    {
        $category = factory(ProductCategory::class)->create(['title' => 'categoryTitle', 'level' => 1]);
        $input = [
            'parent_id' => $category->id,
            'activated' => true,
            'title' => 'subCategoryTitle',
            'description' => 'subCategoryDescription',
            'photoCtrl' => 'newFile',
            'photo' => UploadedFile::fake()->image('photo.jpg'),
        ];

        $response = $this->post('/admin/product/categories', $input);
        $subCategory = ProductCategory::where('title', 'subCategoryTitle')->first();

        $response->assertRedirect('/admin/product/categories');
        $this->assertTrue($subCategory->activated);
        $this->assertEquals('subCategoryTitle', $subCategory->title);
        $this->assertEquals('subCategoryDescription', $subCategory->description);
        $this->assertEquals(2, $subCategory->level);
        $this->assertNotNull($subCategory->photoPath);
        $this->assertFileExists(public_path('storage/' . $subCategory->photoPath));


        //category and child category
        $this->assertCount(1, $category->childCategories);
        $this->assertEquals($subCategory->id, $category->childCategories->first()->id);

        //subCategory and parent/child category
        $this->assertCount(0, $subCategory->childCategories);
        $this->assertEquals($category->id, $subCategory->parentCategory->id);
    }

    /** @test */
    public function can_create_3rdTier_category_from_admin()
    {
        $category = factory(ProductCategory::class)->create(['title' => 'categoryTitle', 'level' => 1]);
        $subCategory = $category->childCategories()->create([
            'activated' => true,
            'title' => 'subCategoryTitle',
            'description' => 'subCategoryDescription',
            'level' => $category->level + 1
        ]);

        $newInput = [
            'parent_id' => $subCategory->id,
            'activated' => true,
            'title' => 'subSubCategoryTitle',
            'description' => 'subSubCategoryDescription',
        ];

        $response = $this->post('/admin/product/categories', $newInput);
        $subSubCategory = ProductCategory::where('title', 'subSubCategoryTitle')->first();

        $response->assertRedirect('/admin/product/categories');
        $this->assertTrue($subSubCategory->activated);
        $this->assertEquals('subSubCategoryTitle', $subSubCategory->title);
        $this->assertEquals('subSubCategoryDescription', $subSubCategory->description);
        $this->assertEquals(3, $subSubCategory->level);

        //sub category and child category
        $this->assertCount(1, $subCategory->childCategories);
        $this->assertEquals($subSubCategory->id, $subCategory->childCategories->first()->id);

        //sub sub category and parent category
        $this->assertEquals($subCategory->id, $subSubCategory->parentCategory->id);
    }

    /** @test */
    public function when_creating_subTier_category_no_photo_is_created_if_no_newFile_command_is_given()
    {
        $category = factory(ProductCategory::class)->create(['title' => 'categoryTitle']);
        $input = [
            'parent_id' => $category->id,
            'activated' => true,
            'title' => 'subCategoryTitle',
            'description' => 'subCategoryDescription',
            'photoCtrl' => '',
            'photo' => UploadedFile::fake()->image('photo.jpg'),
        ];

        $response = $this->post('/admin/product/categories', $input);
        $subCategory = ProductCategory::where('title', 'subCategoryTitle')->first();

        $response->assertRedirect('/admin/product/categories');
        $this->assertNull($subCategory->photoPath);
    }

    /** @test */
    public function can_visit_category_edit_page()
    {
        $category = factory(ProductCategory::class)->create(['title' => 'ASuperCategoryTitle']);

        $response = $this->get('/admin/product/categories/' . $category->id . '/edit');

        $response->assertSuccessful()
            ->assertSee('修改分類')
            ->assertSee($category->title)
            ->assertSee($category->description);

        $subCategory = $category->childCategories()->create([
            'activated' => true,
            'title' => 'niceSubCategoryTitle',
            'description' => 'subCategoryDescription',
            'level' => $category->level + 1
        ]);

        $response = $this->get('/admin/product/categories/' . $subCategory->id . '/edit');
        $response->assertSuccessful()
            ->assertSee('修改分類')
            ->assertSee($category->title)
            ->assertSee($subCategory->title)
            ->assertSee($subCategory->description);
    }

    /** @test */
    public function can_update_category()
    {
        $category = factory(ProductCategory::class)->create(['activated' => true, 'title' => 'CategoryTitle']);

        $firstUpdatedInput = [
            'activated' => false,
            'title' => '1stCategoryTitle',
            'description' => '1stDescription',
            'photoCtrl' => 'newFile',
            'photo' => UploadedFile::fake()->image('photo.jpg'),
        ];

        $response = $this->patch('/admin/product/categories/' . $category->id, $firstUpdatedInput);

        $category = $category->fresh();
        $response->assertRedirect('/admin/product/categories');
        $this->assertEquals(false, $category->activated);
        $this->assertEquals('1stCategoryTitle', $category->title);
        $this->assertEquals('1stDescription', $category->description);
        $this->assertNotNull($category->photoPath);
        $this->assertFileExists(public_path('storage/' . $category->photoPath));


        $firstPhotoPath = $category->photoPath;
        $secondUpdateInput = [
            'activated' => false,
            'title' => '2ndCategoryTitle',
            'description' => '2ndDescription',
            'photoCtrl' => 'newFile',
            'photo' => UploadedFile::fake()->image('photo2.jpg'),
        ];
        $response = $this->patch('/admin/product/categories/' . $category->id, $secondUpdateInput);

        $category = $category->fresh();
        $response->assertRedirect('/admin/product/categories');
        $this->assertNotNull($category->photoPath);
        $this->assertFileExists(public_path('storage/' . $category->photoPath));
        $this->assertFileNotExists(public_path('storage/' . $firstPhotoPath));


        //delete photo
        $secondPhotoPath = $category->photoPath;
        $thirdUpdatedInput = [
            'activated' => false,
            'title' => '3rdCategoryTitle',
            'description' => '3rdUpdatedDescription',
            'photoCtrl' => 'deleteFile',
            'photo' => '',
        ];

        $response = $this->patch('/admin/product/categories/' . $category->id, $thirdUpdatedInput);

        $category = $category->fresh();
        $response->assertRedirect('/admin/product/categories');
        $this->assertNull($category->photoPath);
        $this->assertFileNotExists(public_path('storage\\' . $secondPhotoPath));
    }

    /** @test */
    public function a_sub_cat_can_update_its_parent_id()
    {
        $subCategory = factory(ProductCategory::class)->create(['parent_id' => 1, 'activated' => true, 'title' => 'CategoryTitle']);

        $firstUpdatedInput = [
            'activated' => false,
            'title' => '1stCategoryTitle',
            'description' => '1stDescription',
        ];

        $response = $this->patch('/admin/product/categories/' . $subCategory->id, $firstUpdatedInput);

        $response->assertRedirect('/admin/product/categories/');
        $updatedSubCategory = $subCategory->fresh();

        $this->assertEquals($subCategory->parent_id, $updatedSubCategory->parent_id);


        $secondUpdatedInput = [
            'activated' => false,
            'title' => '1stCategoryTitle',
            'description' => '1stDescription',
            'parent_id' => 2
        ];

        $response = $this->patch('/admin/product/categories/' . $subCategory->id, $secondUpdatedInput);
        $response->assertRedirect('/admin/product/categories/');
        $updatedSubCategory = $subCategory->fresh();

        $this->assertEquals(2, $updatedSubCategory->parent_id);
    }

    /** @test */
    public function can_delete_a_category()
    {
        $category = factory(ProductCategory::class)->create();

        $response = $this->delete('/admin/product/categories/' . $category->id);

        $response->assertRedirect('/admin/product/categories');
        $this->assertNull($category->fresh());
    }

    /** @test */
    public function can_update_ranking()
    {
        $categories = factory(ProductCategory::class, 3)->create();
        $rankingInput = [
            'id' => [$categories[0]->id, $categories[1]->id, $categories[2]->id],
            'ranking' => [5, 4, 3]
        ];

        $response = $this->patch('/admin/product/categories/ranking', $rankingInput);

        $response->assertRedirect('/admin/product/categories');
        $this->assertEquals(5, $categories[0]->fresh()->ranking);
        $this->assertEquals(4, $categories[1]->fresh()->ranking);
        $this->assertEquals(3, $categories[2]->fresh()->ranking);
    }

    private function clearTestPhotoFiles()
    {
        $files = \File::files(public_path('storage/images'));
        collect($files)->each(function ($file) {
            \File::delete($file);
        });
    }

    public function tearDown()
    {
        $this->clearTestPhotoFiles();
    }
}
