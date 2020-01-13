<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Link;
use App\Models\Category\LinkCategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LinksTest extends TestCase
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
        $link = factory(Link::class)->create();

        $response = $this->get('/admin/links');

        $response->assertSuccessful()
            ->assertSee($link->title);
    }

    /** @test */
    public function can_visit_create_page()
    {
        factory(LinkCategory::class)->create(['title' => 'linksCatTitle']);
        $response = $this->get('/admin/links/create');

        $response->assertSuccessful()
            ->assertSee('新增相關連結')
            ->assertSee('linksCatTitle');
    }

    /** @test */
    public function can_visit_edit_page()
    {
        factory(LinkCategory::class)->create(['title' => 'linksCatTitle']);
        $link = factory(Link::class)->create();


        $response = $this->get('/admin/links/' . $link->id . '/edit');

        $response->assertSuccessful()
            ->assertSee('修改相關連結')
            ->assertSee($link->title)
            ->assertSee('linksCatTitle');
    }

    /** @test */
    public function can_create_a_new_link()
    {
        $newLinkInfo = [
            'cat_id' => 1,
            'title' => 'ANewLink',
            'published' => true,
            'url' =>  'www.some_domain.com'
        ];

        $response = $this->post('admin/links', $newLinkInfo);

        $links = Link::first();
        $response->assertRedirect('admin/links');
        $this->assertEquals(1, $links->cat_id);
        $this->assertEquals('ANewLink', $links->title);
        $this->assertEquals('www.some_domain.com', $links->url);
        $this->assertTrue($links->published);
    }


    /** @test */
    public function can_update_an_existing_link()
    {
        $link = factory(Link::class)->create();
        $newLinkInput = [
            'cat_id' => 500,
            'title' => 'NewTitle',
            'published' => false,
            'url' => 'http://a.b.com'
        ];

        $response = $this->patch('/admin/links/' . $link->id, $newLinkInput);

        $links = $link->fresh();
        $response->assertRedirect('admin/links');
        $this->assertEquals(500, $links->cat_id);
        $this->assertEquals('NewTitle', $links->title);
        $this->assertEquals(false, $links->published);
        $this->assertEquals('http://a.b.com', $links->url);
    }

    /** @test */
    public function can_delete_many_links_at_one_time()
    {
        $links = factory(Link::class, 5)->create();
        $input = [
            'chosen_id' => [
                $links[0]->id,
                $links[2]->id,
                $links[4]->id],
            'action' => 'delete'
        ];

        $response = $this->patch('/admin/links/action', $input);

        $response->assertSuccessful();
        $this->assertNull($links[0]->fresh());
        $this->assertNotNull($links[1]->fresh());
        $this->assertNull($links[2]->fresh());
        $this->assertNotNull($links[3]->fresh());
        $this->assertNull($links[4]->fresh());
    }

    /** @test */
    public function can_delete_a_link()
    {
        $link = factory(Link::class)->create();

        $response = $this->delete('/admin/links/' . $link->id);

        $response->assertRedirect('/admin/links');
        $this->assertNull($link->fresh());
    }
    
    /** @test */
    public function can_set_published_for_many_links_at_one_time()
    {
        $links = factory(Link::class, 3)->create(['published' => false]);
        $links->each(function ($links) {
            $this->assertFalse($links->published);
        });
        $input = [
            'chosen_id' => [
                $links[0]->id,
                $links[2]->id
            ],
            'action' => 'setToShow'
        ];

        $response = $this->patch('/admin/links/action', $input);

        $response->assertSuccessful();
        $this->assertTrue($links[0]->fresh()->published);
        $this->assertFalse($links[1]->fresh()->published);
        $this->assertTrue($links[2]->fresh()->published);
    }

    /** @test */
    public function can_set_noShow_for_many_links_at_one_time()
    {
        $links = factory(Link::class, 3)->create(['published' => true]);
        $links->each(function ($links) {
            $this->assertTrue($links->published);
        });
        $input = [
            'chosen_id' => [
                $links[0]->id,
                $links[2]->id
            ],
            'action' => 'setToNoShow'
        ];

        $response = $this->patch('/admin/links/action', $input);

        $response->assertSuccessful();
        $this->assertFalse($links[0]->fresh()->published);
        $this->assertTrue($links[1]->fresh()->published);
        $this->assertFalse($links[2]->fresh()->published);
    }


    /** @test */
    public function published_is_required_to_create_a_new_link()
    {
        $this->withExceptionHandling();

        $newLinksInfo = [
            'title' => 'ANewLinks',
        ];

        $response = $this->post('admin/links', $newLinksInfo);

        $this->assertValidationError($response, 'published');
    }

    /** @test */
    public function published_should_be_boolean_when_creating_a_link()
    {
        $this->withExceptionHandling();

        $newLinksInfo = [
            'title' => 'ANewLinks',
            'published' => 'notABoolean',
            'body' => 'SomeContent Body'
        ];

        $response = $this->post('admin/links', $newLinksInfo);

        $this->assertValidationError($response, 'published');
    }


    /** @test */
    public function published_is_required_to_update_a_link()
    {
        $this->withExceptionHandling();

        $link = factory(Link::class)->create();
        $newLinksInfo = [
            'title' => '123',
        ];

        $response = $this->patch('/admin/links/' . $link->id, $newLinksInfo);
        $this->assertValidationError($response, 'published');
    }

    /** @test */
    public function published_should_be_boolean_when_updating_a_link()
    {
        $this->withExceptionHandling();

        $link = factory(Link::class)->create();
        $newLinksInfo = [
            'title' => 'ANewLinks',
            'published' => 'notABoolean',
        ];

        $response = $this->patch('/admin/links/' . $link->id, $newLinksInfo);
        $this->assertValidationError($response, 'published');
    }
}
