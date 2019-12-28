<?php

use App\Models\About;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        About::truncate();

// todo: remove this

//        $about = factory(About::class)->create(['published' => true,'title' => '關於我們']);
//        $this->generateEnglishVersionContent($about);
//
//        $about = factory(About::class)->create(['published' => true,'title' => '工廠位置']);
//        $this->generateEnglishVersionContent($about);
    }

    /**
     * @param Model $about
     */
    private function generateEnglishVersionContent(Model $about)
    {
        if (config('app.english_enabled')) {
            $about->update([
                'title_en' => $about->title . "_en",
                'body_en' => $about->body . "_en",
            ]);
        }
    }
}
