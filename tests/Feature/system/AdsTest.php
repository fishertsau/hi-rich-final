<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Ad;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdsTest extends TestCase
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
        $response = $this->get('/admin/ads');

        $response->assertSuccessful();
    }

    /** @test */
    public function can_visit_create_page()
    {
        $response = $this->get('/admin/ads/create');

        $response->assertSuccessful()
            ->assertSee('新增廣告');
    }

    /** @test */
    public function can_visit_edit_page()
    {
        $ad = factory(Ad::class)->create();
        $response = $this->get('/admin/ads/' . $ad->id . '/edit');

        $response->assertSuccessful()
            ->assertSee('修改廣告')
            ->assertSee($ad->title);
    }

    /** @test */
    public function can_create_a_new_ad()
    {
        $newAdInfo = [
            'title' => 'ANewAd',
            'location' => 1,
            'published' => true,
            'photoCtrl' => 'newFile',
            'photo' => UploadedFile::fake()->image('photo.jpg'),
        ];

        $response = $this->post('admin/ads', $newAdInfo);

        $ad = Ad::first();
        $response->assertRedirect('admin/ads');
        $this->assertEquals('ANewAd', $ad->title);
        $this->assertEquals(1, $ad->location);
        $this->assertTrue((boolean)$ad->published);
        $this->assertSame(1, (int)$ad->ranking);
        $this->assertNotNull($ad->photoPath);
        $this->assertFileExists(public_path('storage/' . $ad->photoPath));
    }

    /** @test */
    public function no_photo_file_is_created_if_no_newFile_command_given()
    {
        $newAdInfo = [
            'cat_id' => 1,
            'title' => 'ANewAd',
            'location' => 1,
            'published' => true,
            'url' => 'www.some_domain.com',
            'photoCtrl' => '',
            'photo' => UploadedFile::fake()->image('photo.jpg'),
        ];

        $response = $this->post('admin/ads', $newAdInfo);

        $ad = Ad::first();
        $response->assertRedirect('admin/ads');
        $this->assertNull($ad->photoPath);
    }
    
    /** @test */
    public function can_update_an_existing_ad()
    {
        $ad = factory(Ad::class)->create();
        $newAdInfo = [
            'title' => 'ANewAd',
            'location' => 1,
            'published' => true,
            'photoCtrl' => 'newFile',
            'photo' => UploadedFile::fake()->image('photo1.jpg'),
        ];

        $response = $this->patch('/admin/ads/' . $ad->id, $newAdInfo);

        $ad = $ad->fresh();
        $response->assertRedirect('admin/ads');
        $this->assertEquals('ANewAd', $ad->title);
        $this->assertEquals(1, $ad->location);
        $this->assertTrue((boolean)$ad->published);
        $this->assertNotNull($ad->ranking);
        $this->assertSame(1, (int)$ad->ranking);
        
        //update again with a new photo
        $firstPhotoPath = $ad->photoPath;

        $newAdInfo = [
            'title' => 'ANewAd',
            'location' => 1,
            'published' => true,
            'photoCtrl' => 'newFile',
            'photo' => UploadedFile::fake()->image('photo2.jpg'),
        ];

        $response = $this->patch('/admin/ads/' . $ad->id, $newAdInfo);

        $ad = $ad->fresh();
        $response->assertRedirect('admin/ads');
        $this->assertNotNull($ad->photoPath);
        $this->assertFileExists(public_path('storage/' . $ad->photoPath));
        $this->assertFileNotExists(public_path('storage/' . $firstPhotoPath));
        
        
        //update again to delete photo
        $secondPhotoPath = $ad->photoPath;
        $newAdInfo = [
            'title' => 'ANewAd',
            'location' => 1,
            'published' => true,
            'photoCtrl' => 'deleteFile',
            'photo' => UploadedFile::fake()->image('photo3.jpg'),
        ];

        $response = $this->patch('/admin/ads/' . $ad->id, $newAdInfo);
        
        $ad = $ad->fresh();
        $response->assertRedirect('admin/ads');
        $this->assertNull($ad->photoPath);
        $this->assertFileNotExists(public_path('storage/' . $secondPhotoPath));
    }

    /** @test */
    public function can_update_ranking()
    {
        $ad = factory(Ad::class, 3)->create();
        $rankingInput = [
            'id' => [$ad[0]->id, $ad[1]->id, $ad[2]->id],
            'ranking' => [5, 4, 3]
        ];

        $response = $this->patch('/admin/ads/ranking', $rankingInput);

        $response->assertRedirect('/admin/ads');
        $this->assertEquals(5, $ad[0]->fresh()->ranking);
        $this->assertEquals(4, $ad[1]->fresh()->ranking);
        $this->assertEquals(3, $ad[2]->fresh()->ranking);
    }

    /** @test */
    public function can_delete_an_ad()
    {
        $ad = factory(Ad::class)->create();

        $response = $this->delete('/admin/ads/' . $ad->id);

        $response->assertRedirect('/admin/ads');
        $this->assertNull($ad->fresh());
    }
}
