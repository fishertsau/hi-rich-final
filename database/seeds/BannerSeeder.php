<?php

use App\Models\Ad;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    private $photoList = [
        'banner01.jpg',
        'banner02.jpg',
        'banner03.jpg',
        'banner04.jpg'
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ad::truncate();

        foreach ($this->photoList as $photo) {
            factory(Ad::class)->create([
                'photoPath' =>  $this->copyPhoto($photo)
            ]);
        }
    }

    private function copyPhoto($fileName)
    {
        $newPhotoPath = str_random(40) . '.jpg';

        $targetOriginFile = public_path(config('filesystems.app.origin_banners_image_baseDir') . '/' . $fileName);
        $targetDestFile = public_path(
            config('filesystems.app.public_storage_root') . '/images/' . $newPhotoPath);

        File::copy($targetOriginFile, $targetDestFile);

        return 'images/' . $newPhotoPath;
    }
}
