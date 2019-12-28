<?php

namespace Tests\Feature\system;

use App\User;
use Tests\TestCase;
use App\Models\Banner;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BannerTest extends TestCase
{
    use DatabaseMigrations;

    function setUp()
    {
        parent::setUp();
        $this->actingAs(factory(User::class)->make());
    }


    /** @test */
    public function can_visit_edit_page()
    {
        $response = $this->get('/admin/banner');

        $response->assertSuccessful()
            ->assertSee('Banner-1')
            ->assertSee('Banner-2');
    }


    /** @test */
    public function testUpdateBanner()
    {
        $banner_info = [
            'titleA' => '1st title',
            'subTitleA' => '1st subTitle',
            //BannerA
            'photoA' => UploadedFile::fake()->image('photo1.jpg'),
            'bannerA_photoCtrl' => 'newFile',

            //Banner for English version
            'photoA_en' => UploadedFile::fake()->image('photo1.jpg'),
            'bannerA_photoEnCtrl' => 'newFile',

            //BannerB
            'titleB' => '2nd title',
            'subTitleB' => '2nd subTitle',
            'photoB' => UploadedFile::fake()->image('photo2.jpg'),
            'bannerB_photoCtrl' => 'newFile',

            //Banner for English version
            'photoB_en' => UploadedFile::fake()->image('photo2.jpg'),
            'bannerB_photoEnCtrl' => 'newFile',
        ];

        $response = $this->patch('/admin/banner', $banner_info);

        $bannerA = Banner::first();
        $bannerB = Banner::last();
        $response->assertRedirect('/admin/banner');
        $this->assertEquals('1st title', $bannerA->title);
        $this->assertEquals('1st subTitle', $bannerA->subTitle);
        $this->assertNotNull($bannerA->photoPath);
        $this->assertFileExists(public_path('storage') . '/' . $bannerA->photoPath);
        $this->assertNotNull($bannerA->photoPath_en);
        $this->assertFileExists(public_path('storage/' . $bannerA->photoPath_en));

        $this->assertEquals('2nd title', $bannerB->title);
        $this->assertEquals('2nd subTitle', $bannerB->subTitle);
        $this->assertFileExists(public_path('storage/' . $bannerB->photoPath));
        $this->assertNotNull($bannerB->photoPath);
        $this->assertFileExists(public_path('storage/' . $bannerB->photoPath_en));
        $this->assertNotNull($bannerB->photoPath_en);
    }


    /** @test */
    public function can_keep_original_photo_file()
    {
        $firstBanner = Banner::create([
            'photoPath' => 'photoPathForBannerA',
            'photoPath_en' => 'photoPathEnForBannerA',
        ]);
        $secondBanner = Banner::create([
            'photoPath' => 'photoPathForBannerB',
            'photoPath_en' => 'photoPathEnForBannerB',
        ]);

        $banner_info = [
            'photoA' => UploadedFile::fake()->image('photo1new.jpg'),
            'bannerA_photoCtrl' => 'originalFile',

            'photoA_en' => UploadedFile::fake()->image('photo1new.jpg'),
            'bannerA_photoEnCtrl' => 'originalFile',

            'photoB' => UploadedFile::fake()->image('photo2new.png'),
            'bannerB_photoCtrl' => 'originalFile',

            'photoB_en' => UploadedFile::fake()->image('photo2new.png'),
            'bannerB_photoEnCtrl' => 'originalFile',
        ];

        $this->patch('/admin/banner', $banner_info);

        $this->assertEquals('photoPathForBannerA', $firstBanner->fresh()->photoPath);
        $this->assertEquals('photoPathEnForBannerA', $firstBanner->fresh()->photoPath_en);
        $this->assertEquals('photoPathForBannerB', $secondBanner->fresh()->photoPath);
        $this->assertEquals('photoPathEnForBannerB', $secondBanner->fresh()->photoPath_en);
    }


    /** @test */
    public function can_update_photo_file()
    {
        $firstBanner = Banner::create([
            'photoPath' => $this->generateAndPersistFile(),
            'photoPath_en' => $this->generateAndPersistFile(),
        ]);
        $secondBanner = Banner::create([
            'photoPath' => $this->generateAndPersistFile(),
            'photoPath_en' => $this->generateAndPersistFile(),
        ]);

        $oldFirstBannerPhotoPath = $firstBanner->photoPath;
        $oldFirstBannerPhotoPath_en = $firstBanner->photoPath_en;
        $oldSecondBannerPhotoPath = $secondBanner->photoPath;
        $oldSecondBannerPhotoPath_en = $secondBanner->photoPath_en;

        $this->assertFileExists(public_path('storage/' . $oldFirstBannerPhotoPath));
        $this->assertFileExists(public_path('storage/' . $oldFirstBannerPhotoPath_en));
        $this->assertFileExists(public_path('storage/' . $oldSecondBannerPhotoPath));
        $this->assertFileExists(public_path('storage/' . $oldSecondBannerPhotoPath_en));

        $banner_info = [
            'photoA' => UploadedFile::fake()->image('photo1new.jpg'),
            'bannerA_photoCtrl' => 'newFile',
            'photoA_en' => UploadedFile::fake()->image('photo1new.jpg'),
            'bannerA_photoEnCtrl' => 'newFile',

            'photoB' => UploadedFile::fake()->image('photo2new.jpg'),
            'bannerB_photoCtrl' => 'newFile',
            'photoB_en' => UploadedFile::fake()->image('photo2new.jpg'),
            'bannerB_photoEnCtrl' => 'newFile',
        ];

        //act
        $this->patch('/admin/banner', $banner_info);


        $newPhotoPathA = Banner::first()->photoPath;
        $newPhotoPathB = Banner::last()->photoPath;

        //assert
        $this->assertNotEquals($oldFirstBannerPhotoPath, $newPhotoPathA);
        $this->assertNotEquals($oldSecondBannerPhotoPath, $newPhotoPathB);
        $this->assertFileExists(public_path('storage/' . $newPhotoPathA));
        $this->assertFileExists(public_path('storage/' . $newPhotoPathB));
        $this->assertFileNotExists(public_path('storage/' . $oldFirstBannerPhotoPath));
        $this->assertFileNotExists(public_path('storage/' . $oldSecondBannerPhotoPath));
    }

    /** @test */
    public function can_delete_photo()
    {
        $firstBanner = Banner::create([
            'photoPath' => $this->generateAndPersistFile(),
            'photoPath_en' => $this->generateAndPersistFile(),
        ]);
        $secondBanner = Banner::create([
            'photoPath' => $this->generateAndPersistFile(),
            'photoPath_en' => $this->generateAndPersistFile()
        ]);

        $oldFirstBannerPhotoPath = $firstBanner->photoPath;
        $oldFirstBannerPhotoPath_en = $firstBanner->photoPath_en;
        $oldSecondBannerPhotoPath = $secondBanner->photoPath;
        $oldSecondBannerPhotoPath_en = $secondBanner->photoPath_en;

        $this->assertFileExists(public_path('storage/' . $oldFirstBannerPhotoPath));
        $this->assertFileExists(public_path('storage/' . $oldFirstBannerPhotoPath_en));
        $this->assertFileExists(public_path('storage/' . $oldSecondBannerPhotoPath));
        $this->assertFileExists(public_path('storage/' . $oldSecondBannerPhotoPath_en));

        $banner_info = [
            'bannerA_photoCtrl' => 'deleteFile',
            'bannerA_photoEnCtrl' => 'deleteFile',
            'bannerB_photoCtrl' => 'deleteFile',
            'bannerB_photoEnCtrl' => 'deleteFile',
        ];

        $this->patch('/admin/banner', $banner_info);

        $newPhotoPathA = Banner::first()->photoPath;
        $newPhotoPathB = Banner::last()->photoPath;

        $this->assertEmpty($newPhotoPathA);
        $this->assertEmpty($newPhotoPathB);
        $this->assertFileNotExists(public_path('storage/' . $oldFirstBannerPhotoPath));
        $this->assertFileNotExists(public_path('storage/' . $oldFirstBannerPhotoPath_en));
        $this->assertFileNotExists(public_path('storage/' . $oldSecondBannerPhotoPath));
        $this->assertFileNotExists(public_path('storage/' . $oldSecondBannerPhotoPath_en));
    }


    private function clearPhotoFiles()
    {
        $files = \File::files(public_path('storage/images'));
        collect($files)->each(function ($file) {
            \File::delete($file);
        });
    }

    public function tearDown()
    {
        $this->clearPhotoFiles();
    }

    /**
     * @return false|string
     */
    private function generateAndPersistFile()
    {
        return UploadedFile::fake()->image('photo1.jpg')->store('images', 'public');
    }
}
