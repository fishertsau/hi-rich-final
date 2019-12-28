<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->clearTestPhotoFiles();

        $this->call(WebConfigSeeder::class);
        $this->call(BannerSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(SystemUserSeeder::class);
        $this->call(AdminSeeder::class);

        if (config('app.admin.about_list')) {
            $this->call(AboutSeeder::class);
        }

        if (config('app.admin.services')) {
            $this->call(ServiceSeeder::class);
        }

        if (config('app.admin.news')) {
            $this->call(NewsSeeder::class);
        }

        if (config('app.admin.samples')) {
            $this->call(SampleSeeder::class);
        }
    }

    private function clearTestPhotoFiles()
    {
        $files = \File::files(public_path('storage/images'));
        collect($files)->each(function ($file) {
            \File::delete($file);
        });
    }
}
