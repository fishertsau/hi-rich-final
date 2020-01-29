<?php

use App\Models\Ad;
use Illuminate\Database\Seeder;

class AdSeeder extends Seeder
{
    private $bannerPhotoList = [
        'banner01.jpg',
        'banner02.jpg',
        'banner03.jpg',
        'banner04.jpg'
    ];

    private $productPhotoList = [
        'home-a.jpg',
        'home-b.jpg',
        'home-c.jpg',
        'home-d.jpg',
    ];

    private $storePhoto = [
        'store.jpg',
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ad::truncate();

        // banner
        foreach ($this->bannerPhotoList as $photo) {
            factory(Ad::class)->create([
                'location' => Ad::LOCATION_BANNER,
                'photoPath' =>
                    $this->copyPhoto(
                        $photo,
                        public_path(config('filesystems.app.origin_banners_image_baseDir'))
                    )]);
        }

        // 首頁產品
        foreach ($this->productPhotoList as $photo) {
            factory(Ad::class)->create([
                'location' => Ad::LOCATION_HOME_PAGE,
                'photoPath' =>
                    $this->copyPhoto(
                        $photo,
                        public_path(config('filesystems.app.origin_home_image_baseDir'))
                    )]);
        }
        
        // 首頁產品
        foreach ($this->storePhoto as $photo) {
            factory(Ad::class)->create([
                'location' => Ad::LOCATION_HOME_ACTIVITY,
                'photoPath' =>
                    $this->copyPhoto(
                        $photo,
                        public_path(config('filesystems.app.origin_home_image_baseDir'))
                    )]);
        }
    }

    private function copyPhoto($fileName, $fileDir)
    {
        $newPhotoPath = str_random(40) . '.jpg';

        $targetOriginFile = $fileDir . '/' . $fileName;
        $targetDestFile = public_path(
            config('filesystems.app.public_storage_root') . '/images/' . $newPhotoPath);

        File::copy($targetOriginFile, $targetDestFile);

        return 'images/' . $newPhotoPath;
    }
}
