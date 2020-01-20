<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Banner;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BannersTest extends TestCase
{
    use DatabaseMigrations;

    function setUp()
    {
        parent::setUp();
        $this->actingAs(factory(User::class)->make());
    }

    /** @test */
    public function can_visit_list_page()
    {
        $response = $this->get('/admin/banners');

        $response->assertSuccessful();
    }

    /** @test */
    public function can_visit_create_page()
    {
        $response = $this->get('/admin/banners/create');

        $response->assertSuccessful()
            ->assertSee('新增跑馬燈');
    }

    /** @test */
    public function can_visit_edit_page()
    {
        $banner = factory(Banner::class)->create();
        $response = $this->get('/admin/banners/' . $banner->id . '/edit');

        $response->assertSuccessful()
            ->assertSee('修改跑馬燈')
            ->assertSee($banner->title);
    }

    /** @test */
    public function can_create_a_new_banner()
    {
        $newBannerInfo = [
            'title' => 'ANewBanner',
            'published' => true,
            'photoCtrl' => 'newFile',
            'photo' => UploadedFile::fake()->image('photo.jpg'),
        ];

        $response = $this->post('admin/banners', $newBannerInfo);

        $banner = Banner::first();
        $response->assertRedirect('admin/banners');
        $this->assertEquals('ANewBanner', $banner->title);
        $this->assertTrue((boolean)$banner->published);
        $this->assertSame(1, (int)$banner->ranking);
        $this->assertNotNull($banner->photoPath);
        $this->assertFileExists(public_path('storage/' . $banner->photoPath));
    }

    /** @test */
    public function no_photo_file_is_created_if_no_newFile_command_given()
    {
        $newBannerInfo = [
            'cat_id' => 1,
            'title' => 'ANewBanner',
            'published' => true,
            'url' => 'www.some_domain.com',
            'photoCtrl' => '',
            'photo' => UploadedFile::fake()->image('photo.jpg'),
        ];

        $response = $this->post('admin/banners', $newBannerInfo);

        $banner = Banner::first();
        $response->assertRedirect('admin/banners');
        $this->assertNull($banner->photoPath);
    }
    
    /** @test */
    public function can_update_an_existing_banner()
    {
        $banner = factory(Banner::class)->create();
        $newBannerInfo = [
            'title' => 'ANewBanner',
            'published' => true,
            'photoCtrl' => 'newFile',
            'photo' => UploadedFile::fake()->image('photo1.jpg'),
        ];

        $response = $this->patch('/admin/banners/' . $banner->id, $newBannerInfo);

        $banner = $banner->fresh();
        $response->assertRedirect('admin/banners');
        $this->assertEquals('ANewBanner', $banner->title);
        $this->assertTrue((boolean)$banner->published);
        $this->assertNotNull($banner->ranking);
        $this->assertSame(1, (int)$banner->ranking);
        
        //update again with a new photo
        $firstPhotoPath = $banner->photoPath;

        $newBannerInfo = [
            'title' => 'ANewBanner',
            'published' => true,
            'photoCtrl' => 'newFile',
            'photo' => UploadedFile::fake()->image('photo2.jpg'),
        ];

        $response = $this->patch('/admin/banners/' . $banner->id, $newBannerInfo);

        $banner = $banner->fresh();
        $response->assertRedirect('admin/banners');
        $this->assertNotNull($banner->photoPath);
        $this->assertFileExists(public_path('storage/' . $banner->photoPath));
        $this->assertFileNotExists(public_path('storage/' . $firstPhotoPath));
        
        
        //update again to delete photo
        $secondPhotoPath = $banner->photoPath;
        $newBannerInfo = [
            'title' => 'ANewBanner',
            'published' => true,
            'photoCtrl' => 'deleteFile',
            'photo' => UploadedFile::fake()->image('photo3.jpg'),
        ];

        $response = $this->patch('/admin/banners/' . $banner->id, $newBannerInfo);
        
        $banner = $banner->fresh();
        $response->assertRedirect('admin/banners');
        $this->assertNull($banner->photoPath);
        $this->assertFileNotExists(public_path('storage/' . $secondPhotoPath));
    }

    /** @test */
    public function can_update_ranking()
    {
        $banner = factory(Banner::class, 3)->create();
        $rankingInput = [
            'id' => [$banner[0]->id, $banner[1]->id, $banner[2]->id],
            'ranking' => [5, 4, 3]
        ];

        $response = $this->patch('/admin/banners/ranking', $rankingInput);

        $response->assertRedirect('/admin/banners');
        $this->assertEquals(5, $banner[0]->fresh()->ranking);
        $this->assertEquals(4, $banner[1]->fresh()->ranking);
        $this->assertEquals(3, $banner[2]->fresh()->ranking);
    }

    /** @test */
    public function can_delete_an_banner()
    {
        $banner = factory(Banner::class)->create();

        $response = $this->delete('/admin/banners/' . $banner->id);

        $response->assertRedirect('/admin/banners');
        $this->assertNull($banner->fresh());
    }
}
