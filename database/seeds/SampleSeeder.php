<?php

use App\Models\Sample;
use Illuminate\Database\Seeder;

class SampleSeeder extends Seeder
{
    private $photoList = [
        'service1.jpg',
        'service2.jpg',
        'service3.jpg',
        'service4.jpg',
        'service5.jpg',
        'service6.jpg',
        'service7.jpg',
        'service8.jpg',
        'service9.jpg'
    ];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sample::truncate();

        collect(range(1, 100))->each(function () {
            factory(Sample::class)->create([
                'photoPath' => $this->copyPhoto()
            ]);
        });
    }


    private function copyPhoto()
    {
        $photoPath = 'images/' . str_random(40) . '.jpg';
        $fileName = collect($this->photoList)->random();
        File::copy(public_path('images/' . $fileName),
            public_path('storage/' . $photoPath));

        return $photoPath;
    }
}
