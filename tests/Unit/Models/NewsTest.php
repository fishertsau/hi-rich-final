<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\News;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NewsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_get_news_with_the_published_since_and_until_range()
    {
        //within
        $news1 = create(News::class, [
            'published_since' => Carbon::now()->subWeek(1),
            'published_until' => Carbon::now()->addWeek(1),
        ]);

        //before within
        $news2 = create(News::class, [
            'published_since' => Carbon::now()->subWeek(2),
            'published_until' => Carbon::now()->subWeek(1)
        ]);

        //after since, no until
        $news3 = create(News::class, [
            'published_since' => Carbon::now()->subWeek(1),
            'published_until' => null
        ]);

        //start from future
        $news4 = create(News::class, [
            'published_since' => Carbon::now()->addWeek(1),
            'published_until' => null
        ]);

        //after within
        $news5 = create(News::class, [
            'published_since' => Carbon::now()->addWeek(1),
            'published_until' => Carbon::now()->addWeek(3)
        ]);

        $returnedNewsList = News::withinEffective()->get()->pluck('id');

        $this->assertContains($news1->id, $returnedNewsList);
        $this->assertContains($news3->id, $returnedNewsList);
        $this->assertNotContains($news2->id, $returnedNewsList);
        $this->assertNotContains($news4->id, $returnedNewsList);
        $this->assertNotContains($news5->id, $returnedNewsList);
    }


    /** @test */
    public function can_get_its_previous_or_next_news()
    {
        $newsA = create(News::class, [
            'published' => true,
            'published_since' => Carbon::now()->subWeek(5),
            'published_until' => null
        ]);

        $newsB = create(News::class, [
            'published' => true,
            'published_since' => Carbon::now()->subWeek(4),
            'published_until' => null
        ]);

        $newsC = create(News::class, [
            'published' => true,
            'published_since' => Carbon::now()->subWeek(3),
            'published_until' => null
        ]);

        $newsD = create(News::class, [
            'published' => true,
            'published_since' => Carbon::now()->subWeek(2),
            'published_until' => null
        ]);

        $newsE = create(News::class, [
            'published' => true,
            'published_since' => Carbon::now()->subWeek(1),
            'published_until' => null
        ]);


        $this->assertEquals($newsC->next()->id, $newsB->id);
        $this->assertEquals($newsC->previous()->id, $newsD->id);

        $this->assertEquals($newsE->next()->id, $newsD->id);
        $this->assertEquals($newsE->previous()->id, $newsA->id);

        $this->assertEquals($newsA->next()->id, $newsE->id);
        $this->assertEquals($newsA->previous()->id, $newsB->id);

    }
}
