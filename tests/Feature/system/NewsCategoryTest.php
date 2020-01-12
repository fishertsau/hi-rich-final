<?php

namespace Tests\Feature\system;

use App\User;
use Tests\TestCase;
use App\Models\WebConfig;
use Illuminate\Http\UploadedFile;
use App\Models\Category\NewsCategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NewsCategoryTest extends TestCase
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
        $response = $this->get('/admin/news/categories');

        $response->assertSuccessful()
            ->assertSee('消息分類');
    }

    /** @test */
    public function can_visit_category_create_page()
    {
        $response = $this->get('/admin/news/categories/create');

        $response->assertSuccessful()
            ->assertSee('新增分類');
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

        $response = $this->post('/admin/news/categories', $input);

        $response->assertRedirect('/admin/news/categories');
        
        $category = NewsCategory::firstCat();
        $this->assertTrue($category->activated);
        $this->assertEquals('n', $category->for);
        $this->assertEquals('CategoryTitle', $category->title);
        $this->assertEquals('EnglishCategoryTitle', $category->title_en);
        $this->assertEquals('CategoryDescription', $category->description);
        $this->assertEquals('EnglishCategoryDescription', $category->description_en);
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

        $response = $this->post('/admin/news/categories', $input);
        $category = NewsCategory::firstCat();
        $response->assertRedirect('/admin/news/categories');
        $this->assertNull($category->photoPath);
    }

    /** @test */
    public function can_visit_category_edit_page()
    {
        $category = factory(NewsCategory::class)->create(['title' => 'ASuperCategoryTitle']);

        $response = $this->get('/admin/news/categories/' . $category->id . '/edit');

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


        $response = $this->get('/admin/news/categories/' . $subCategory->id . '/edit');
        $response->assertSuccessful()
            ->assertSee('修改分類')
            ->assertSee($category->title)
            ->assertSee($subCategory->title)
            ->assertSee($subCategory->description);
    }

    /** @test */
    public function the_photo_upload_selection_is_shown_when_category_photo_enabled_is_on()
    {
        $category = factory(NewsCategory::class)->create(['title' => 'ASuperCategoryTitle']);

        WebConfig::create(['category_photo_enabled' => true]);

        $response = $this->get('/admin/news/categories/' . $category->id . '/edit');
        $response->assertSuccessful()
            ->assertSee('維持原圖');


        WebConfig::firstOrCreate()->update(['category_photo_enabled' => false]);
        $response = $this->get('/admin/news/categories/' . $category->id . '/edit');
        $response->assertSuccessful()
            ->assertDontSee('維持原圖');
    }

    /** @test */
    public function can_update_category()
    {
        $category = factory(NewsCategory::class)->create(['activated' => true, 'title' => 'CategoryTitle']);

        $firstUpdatedInput = [
            'activated' => false,
            'title' => '1stCategoryTitle',
            'title_en' => '1stCategoryTitleEnglish',
            'description' => '1stDescription',
            'description_en' => '1stDescriptionEnglish',
            'photoCtrl' => 'newFile',
            'photo' => UploadedFile::fake()->image('photo.jpg'),
        ];

        $response = $this->patch('/admin/news/categories/' . $category->id, $firstUpdatedInput);

        $category = $category->fresh();
        $response->assertRedirect('/admin/news/categories');
        $this->assertEquals(false, $category->activated);
        $this->assertEquals('1stCategoryTitle', $category->title);
        $this->assertEquals('1stCategoryTitleEnglish', $category->title_en);
        $this->assertEquals('1stDescription', $category->description);
        $this->assertEquals('1stDescriptionEnglish', $category->description_en);
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
        $response = $this->patch('/admin/news/categories/' . $category->id, $secondUpdateInput);

        $category = $category->fresh();
        $response->assertRedirect('/admin/news/categories');
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

        $response = $this->patch('/admin/news/categories/' . $category->id, $thirdUpdatedInput);

        $category = $category->fresh();
        $response->assertRedirect('/admin/news/categories');
        $this->assertNull($category->photoPath);
        $this->assertFileNotExists(public_path('storage\\' . $secondPhotoPath));
    }
    
    /** @test */
    public function can_delete_a_category()
    {
        $category = factory(NewsCategory::class)->create();

        $response = $this->delete('/admin/news/categories/' . $category->id);

        $response->assertRedirect('/admin/news/categories');
        $this->assertNull($category->fresh());
    }

    /** @test */
    public function can_update_ranking()
    {
        $categories = factory(NewsCategory::class, 3)->create();
        $rankingInput = [
            'id' => [$categories[0]->id, $categories[1]->id, $categories[2]->id],
            'ranking' => [5, 4, 3]
        ];

        $response = $this->patch('/admin/news/categories/ranking', $rankingInput);

        $response->assertRedirect('/admin/news/categories');
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
