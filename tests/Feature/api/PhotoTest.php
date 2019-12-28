<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Photo;
use Illuminate\Http\UploadedFile;
use App\Repositories\PhotoRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PhotoTest extends TestCase
{
    use DatabaseMigrations;

    function setUp()
    {
        parent::setUp();
        $this->actingAs(factory(User::class)->make());
    }

    /** @test */
    public function can_delete_photo_with_photoPath()
    {
        $photo = factory(Photo::class)->create([
            'photoPath' =>
                UploadedFile::fake()
                    ->create('photoA.jpg')
                    ->store(config('filesystems.app.image_baseDir'), 'public')
        ]);

        $this->assertFileExists(public_path(config('filesystems.app.public_storage_root')) . "/$photo->photoPath");

        $filename = $this->extractFilename($photo);

        $response = $this->delete("/admin/photos/$filename");

        $response->assertJson([
            'status' => 'success',
            'message' => 'a photo is deleted successfully'
        ]);

        $this->assertNull($photo->fresh());
        $this->assertFileNotExists(public_path('storage\\' . $photo->photoPath));
    }

    private function clearTestPhotoFiles()
    {
        $files = \File::files($this->generateImagesDir());
        collect($files)->each(function ($file) {
            \File::delete($file);
        });
    }

    public function tearDown()
    {
        $this->clearTestPhotoFiles();
    }

    /**
     * @param $photo
     * @return mixed
     */
    private function extractFilename($photo)
    {
        return str_replace(config('filesystems.app.image_baseDir') . '/', '', $photo->photoPath);
    }

    /**
     * @return string
     */
    private function generateImagesDir(): string
    {
        return (new PhotoRepository())->generateImagesDir();
    }
}
