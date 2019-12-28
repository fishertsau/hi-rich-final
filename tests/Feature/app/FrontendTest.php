<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\News;
use App\Models\About;
use App\Models\Service;
use App\Models\WebConfig;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FrontendTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_visit_home_page()
    {
        create(WebConfig::class, [
            'address' => 'SuperAddress',
            'tel' => 'SuperTel',
            'fax' => 'SuperFax',
            'intro_title' => 'introTitle',
            'intro' => 'introContent'
        ]);

        $response = $this->get('/');

        $response->assertSuccessful();

        $response->assertViewHas('hotProducts');
        $response->assertViewHas('newss');
        $response->assertSee('SuperAddress');
        $response->assertSee('SuperTel');
        $response->assertSee('SuperFax');
    }


    //============= About =================//
    /** @test */
    public function can_visit_first_about_page()
    {
        $aboutA = create(About::class, ['ranking' => 1]);
        create(About::class, ['ranking' => 2]);

        $response = $this->get('/abouts/first');
        $response->assertSee($aboutA->title);
    }


    /** @test */
    public function can_visit_about_detail_page()
    {
        $about = create(About::class);

        $response = $this->get('/abouts/' . $about->id);

        $response->assertSuccessful();
        $response->assertViewHas('about');
        $response->assertSee($about->title);
        $response->assertSee($about->body);
    }


    /** @test */
    public function can_visit_contact_us_page()
    {
        $response = $this->get('/contacts');

        $response->assertSuccessful();
        $response->assertSee('歡迎洽詢');
    }


    /*===================== News ======================*/
    /** @test */
    public function can_visit_news_index_page()
    {
        $newsA = create(News::class,
            ['published_since' => Carbon::now()->subWeek(1)]);
        $newsB = create(News::class,
            ['published_since' => Carbon::now()->subWeek(2)]);

        $response = $this->get('/news');

        $response->assertSuccessful();
        $response->assertViewHas('newss', function ($viewNewss) use ($newsA, $newsB) {
            $ids = $viewNewss->pluck('id');
            return $ids->contains($newsA->id) && $ids->contains($newsB->id);
        });
    }


    /** @test */
    public function can_visit_news_detail_page()
    {
        $news = factory(News::class)
            ->create(['title' => 'NewsTitle', 'published_since' => Carbon::now()]);

        $response = $this->get('/news/' . $news->id);

        $response->assertSuccessful();
        $response->assertSee($news->title);
        $response->assertSee($news->body);
        $response->assertViewHas('news', function ($viewNews) use ($news) {
            return $viewNews->id === $news->id;
        });
    }


    /** @test */
    public function can_visit_sitemap_page()
    {
        $this->markTestSkipped('this is not required in this project');

        $response = $this->get('/sitemap');

        $response->assertSuccessful();
        $response->assertViewIs('app.sitemap');
        $response->assertViewHas('abouts');
        $response->assertViewHas('categories');
    }
}
