<?php

use App\Models\Link;
use Illuminate\Database\Seeder;

class LinkSeeder extends Seeder
{
    private $photoList = [
        '1111.jpg',
        'MOMO.jpg',
        'SEA.jpg',
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        Link::truncate();

        $newsCatIds = \App\Models\Category\LinkCategory::main()->get()->pluck('id')->toArray();

        $maxId = max($newsCatIds);
        $minId = min($newsCatIds);

        foreach (range(1, 30) as $value) {
            factory(Link::class)->create([
                'cat_id' => random_int($minId, $maxId),
                'photoPath' => $this->copyPhoto(),
                'url' => 'http://google.com.tw'
            ]);
        }
    }
    
    private function copyPhoto()
    {
        $newPhotoPath = str_random(40) . '.jpg';
        $fileName = collect($this->photoList)->random();

        $targetOriginFile = public_path(config('filesystems.app.origin_links_image_baseDir') . '/' . $fileName);
        $targetDestFile = public_path(
            config('filesystems.app.public_storage_root') . '/images/' . $newPhotoPath);

        File::copy($targetOriginFile, $targetDestFile);

        return 'images/' . $newPhotoPath;
    }
}
