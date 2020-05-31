<?php

namespace Tests\Feature;

use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use App\Models\News;
use App\Models\Category\NewsCategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NewsTest extends TestCase
{
    use DatabaseMigrations;

    function setUp()
    {
        parent::setUp();
        $this->actingAs(factory(User::class)->make());
    }

    /** @test */
    public function can_visit_list_page()
    {
        $newsCat = factory(NewsCategory::class)->create();
        $news = factory(News::class)->create(['cat_id' => $newsCat->id ]);

        $response = $this->get('/admin/news');

        $response->assertSuccessful()
            ->assertSee($news->title);
    }

    /** @test */
    public function can_visit_create_page()
    {
        factory(NewsCategory::class)->create(['title' => 'newsCatTitle']);
        $response = $this->get('/admin/news/create');

        $response->assertSuccessful()
            ->assertSee('新增消息')
            ->assertSee('newsCatTitle');
    }

    /** @test */
    public function can_visit_edit_page()
    {
        factory(NewsCategory::class)->create(['title' => 'newsCatTitle']);
        $news = factory(News::class)->create();


        $response = $this->get('/admin/news/' . $news->id . '/edit');

        $response->assertSuccessful()
            ->assertSee('修改消息')
            ->assertSee($news->title)
            ->assertSee('newsCatTitle');
    }

    /** @test */
    public function can_create_a_new_news()
    {
        $newNewsInfo = [
            'cat_id' => 1,
            'title' => 'ANewNews',
            'published' => true,
            'body' => 'SomeContent Body',
            'published_since' => Carbon::parse('-1 week'),
            'published_until' => Carbon::parse('+1 week')
        ];

        $response = $this->post('admin/news', $newNewsInfo);

        $news = News::first();
        $response->assertRedirect('admin/news');
        $this->assertEquals(1, $news->cat_id);
        $this->assertEquals('ANewNews', $news->title);
        $this->assertEquals('SomeContent Body', $news->body);
        $this->assertTrue($news->published);
        $this->assertEquals(Carbon::parse('-1 week')->toDateTimeString(), $news->published_since);
        $this->assertEquals(Carbon::parse('+1 week')->toDateTimeString(), $news->published_until);
        $this->assertNotNull($news->ranking);
        $this->assertSame(0, (int)$news->ranking);
    }


    /** @test */
    public function can_update_an_existing_news()
    {
        $news = factory(News::class)->create();
        $newNewsInput = [
            'cat_id' => 500,
            'title' => 'NewTitle',
            'published' => false,
            'body' => 'NewBody',
            'body_en' => 'SomeContent BodyEnglish',
            'published_since' => Carbon::parse('-1 week'),
            'published_until' => Carbon::parse('+1 week')
        ];

        $response = $this->patch('/admin/news/' . $news->id, $newNewsInput);

        $news = $news->fresh();
        $response->assertRedirect('admin/news');
        $this->assertEquals(500, $news->cat_id);
        $this->assertEquals('NewTitle', $news->title);
        $this->assertEquals('NewBody', $news->body);
        $this->assertEquals(false, $news->published);
        $this->assertEquals(Carbon::parse('-1 week')->toDateTimeString(), $news->published_since);
        $this->assertEquals(Carbon::parse('+1 week')->toDateTimeString(), $news->published_until);
        $this->assertEquals(0, $news->rank);
    }


    /** @test */
    public function can_copy_an_news()
    {
        $news = factory(News::class)->create();

        $response = $this->get('/admin/news/' . $news->id . '/copy');

        $response->assertSuccessful()
            ->assertSee('複製消息')
            ->assertSee($news->title . '(複製)');
    }

    /** @test */
    public function can_update_ranking()
    {
        $news = factory(News::class, 3)->create();
        $rankingInput = [
            'id' => [$news[0]->id, $news[1]->id, $news[2]->id],
            'ranking' => [5, 4, 3]
        ];

        $response = $this->patch('/admin/news/ranking', $rankingInput);

        $response->assertRedirect('/admin/news');
        $this->assertEquals(5, $news[0]->fresh()->ranking);
        $this->assertEquals(4, $news[1]->fresh()->ranking);
        $this->assertEquals(3, $news[2]->fresh()->ranking);
    }


    /** @test */
    public function can_delete_many_news_at_one_time()
    {
        $news = factory(News::class, 5)->create();
        $input = [
            'chosen_id' => [
                $news[0]->id,
                $news[2]->id,
                $news[4]->id],
            'action' => 'delete'
        ];

        $response = $this->patch('/admin/news/action', $input);

        $response->assertSuccessful();
        $this->assertNull($news[0]->fresh());
        $this->assertNotNull($news[1]->fresh());
        $this->assertNull($news[2]->fresh());
        $this->assertNotNull($news[3]->fresh());
        $this->assertNull($news[4]->fresh());
    }

    /** @test */
    public function can_delete_an_news()
    {
        $news = factory(News::class)->create();

        $response = $this->delete('/admin/news/' . $news->id);

        $response->assertRedirect('/admin/news');
        $this->assertNull($news->fresh());
    }


    /** @test */
    public function can_set_published_for_many_news_at_one_time()
    {
        $news = factory(News::class, 3)->create(['published' => false]);
        $news->each(function ($news) {
            $this->assertFalse($news->published);
        });
        $input = [
            'chosen_id' => [
                $news[0]->id,
                $news[2]->id
            ],
            'action' => 'setToShow'
        ];

        $response = $this->patch('/admin/news/action', $input);

        $response->assertSuccessful();
        $this->assertTrue($news[0]->fresh()->published);
        $this->assertFalse($news[1]->fresh()->published);
        $this->assertTrue($news[2]->fresh()->published);
    }

    /** @test */
    public function can_set_noShow_for_many_news_at_one_time()
    {
        $news = factory(News::class, 3)->create(['published' => true]);
        $news->each(function ($news) {
            $this->assertTrue($news->published);
        });
        $input = [
            'chosen_id' => [
                $news[0]->id,
                $news[2]->id
            ],
            'action' => 'setToNoShow'
        ];

        $response = $this->patch('/admin/news/action', $input);

        $response->assertSuccessful();
        $this->assertFalse($news[0]->fresh()->published);
        $this->assertTrue($news[1]->fresh()->published);
        $this->assertFalse($news[2]->fresh()->published);
    }


    /** @test */
    public function published_is_required_to_create_an_new_news()
    {
        $this->withExceptionHandling();

        $newNewsInfo = [
            'title' => 'ANewNews',
        ];

        $response = $this->post('admin/news', $newNewsInfo);

        $this->assertValidationError($response, 'published');
    }

    /** @test */
    public function published_should_be_boolean_when_creating_an_news()
    {
        $this->withExceptionHandling();

        $newNewsInfo = [
            'title' => 'ANewNews',
            'published' => 'notABoolean',
            'body' => 'SomeContent Body'
        ];

        $response = $this->post('admin/news', $newNewsInfo);

        $this->assertValidationError($response, 'published');
    }


    /** @test */
    public function published_is_required_to_update_an_news()
    {
        $this->withExceptionHandling();

        $news = factory(News::class)->create();
        $newNewsInfo = [
            'title' => '123',
            'body' => 'body'
        ];

        $response = $this->patch('/admin/news/' . $news->id, $newNewsInfo);
        $this->assertValidationError($response, 'published');
    }

    /** @test */
    public function published_should_be_boolean_when_updating_an_news()
    {
        $this->withExceptionHandling();

        $news = factory(News::class)->create();
        $newNewsInfo = [
            'title' => 'ANewNews',
            'published' => 'notABoolean',
            'body' => 'SomeContent Body'
        ];

        $response = $this->patch('/admin/news/' . $news->id, $newNewsInfo);
        $this->assertValidationError($response, 'published');
    }
}
