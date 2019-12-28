<?php

use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    private $titles = [
        '三菱控制器維修',
        'FANUC控制器維修',
        '馬達維修',
        'CNC配電工程',
        '機械整修及銷售'
    ];

    private $photoList = [
        'f01.jpg',
        'f02.jpg',
        'f03.jpg',
        'f04.jpg',
        'f05.jpg',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::truncate();

        foreach ($this->titles as $title) {
            $service = factory(Service::class)
                ->create([
                    'published' => true,
                    'title' => $title,
                    'photoPath' => $this->copyPhoto(),
                    'published_in_home' => true]);
            $this->generateEnglishVersionContent($service);
        }
    }

    /**
     * @param Model $service
     */
    private function generateEnglishVersionContent(Model $service)
    {
        if (config('app.english_enabled')) {
            $service->update([
                'title_en' => $service->title . "_en",
                'body_en' => $service->body . "_en",
            ]);
        }
    }

    private function copyPhoto()
    {
        $newPhotoPath = config('filesystems.app.image_baseDir').'/'.str_random(40) . '.jpg';
        $fileName = collect($this->photoList)->random();
        File::copy(base_path() .'/'. $this->productSourceImageDir() . $fileName,
            public_path(config('filesystems.app.public_storage_root')).'/'.$newPhotoPath);

        return $newPhotoPath;
    }

    /**
     * @return string
     */
    private function productSourceImageDir(): string
    {
        return 'public/images/index/';
    }
}
