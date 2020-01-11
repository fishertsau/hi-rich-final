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
        $this->call(ProductCategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(SystemUserSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(NewsCategorySeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(SiteSeeder::class);
    }

    private function clearTestPhotoFiles()
    {
        $files = \File::files(public_path('storage/images'));
        collect($files)->each(function ($file) {
            \File::delete($file);
        });
    }
}
