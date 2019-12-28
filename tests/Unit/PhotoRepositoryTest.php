<?php

namespace Tests\Unit;

use App;
use Image;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Repositories\PhotoRepository;

class PhotoRepositoryTest extends TestCase
{
    private $photoRepo;

    function setUp()
    {
        parent::setUp();
        $this->photoRepo = App::make(PhotoRepository::class);
    }

    /** @test */
    public function can_store_new_photo_file()
    {
        $file = UploadedFile::fake()->image('photo.jpg');

        $filename = $this->photoRepo->store($file);

        $fullFilepath = public_path('storage') . '/' . $filename;
        $img = Image::make($fullFilepath);
        $imgRatio = $img->height() / $img->width();

        $ratioWithin = ($imgRatio > 0.73) && ($imgRatio < 0.77);

        $this->assertFileExists($fullFilepath);
        $this->assertTrue($ratioWithin);
    }
}
