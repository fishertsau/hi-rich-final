<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Site;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SitesTest extends TestCase
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
        $response = $this->get('/admin/sites');

        $response->assertSuccessful();
    }

    /** @test */
    public function can_visit_create_page()
    {
        $response = $this->get('/admin/sites/create');

        $response->assertSuccessful()
            ->assertSee('新增據點');
    }


    /** @test */
    public function can_visit_edit_page()
    {
        $site = factory(Site::class)->create();
        $response = $this->get('/admin/sites/' . $site->id . '/edit');

        $response->assertSuccessful()
            ->assertSee('修改據點')
            ->assertSee($site->name);
    }

    /** @test */
    public function can_create_a_new_site()
    {
        $newSiteInfo = [
            'name' => 'ANewSite',
            'address' => 'Site address',
            'tel' => '02-tel',
            'fax' => '02-fax',
            'email' => 'a@b.com',
            'published' => true,
            'google_map' => 'google map'
        ];

        $response = $this->post('admin/sites', $newSiteInfo);

        $site = Site::first();
        $response->assertRedirect('admin/sites');
        $this->assertEquals('ANewSite', $site->name);
        $this->assertEquals('Site address', $site->address);
        $this->assertEquals('02-tel', $site->tel);
        $this->assertEquals('02-fax', $site->fax);
        $this->assertEquals('a@b.com', $site->email);
        $this->assertTrue((boolean)$site->published);
        $this->assertEquals('google map', $site->google_map);
        $this->assertSame(1, (int)$site->ranking);
    }

    /** @test */
    public function can_update_an_existing_site()
    {
        $site = factory(Site::class)->create();
        $newSiteInfo = [
            'name' => 'ANewSite',
            'address' => 'Site address',
            'tel' => '02-tel',
            'fax' => '02-fax',
            'email' => 'a@b.com',
            'published' => true,
        ];

        $response = $this->patch('/admin/sites/' . $site->id, $newSiteInfo);

        $site = $site->fresh();
        $response->assertRedirect('admin/sites');
        $this->assertEquals('ANewSite', $site->name);
        $this->assertEquals('Site address', $site->address);
        $this->assertEquals('02-tel', $site->tel);
        $this->assertEquals('02-fax', $site->fax);
        $this->assertEquals('a@b.com', $site->email);
        $this->assertTrue((boolean)$site->published);
        $this->assertNotNull($site->ranking);
        $this->assertSame(1, (int)$site->ranking);
    }

    /** @test */
    public function can_update_ranking()
    {
        $site = factory(Site::class, 3)->create();
        $rankingInput = [
            'id' => [$site[0]->id, $site[1]->id, $site[2]->id],
            'ranking' => [5, 4, 3]
        ];

        $response = $this->patch('/admin/sites/ranking', $rankingInput);

        $response->assertRedirect('/admin/sites');
        $this->assertEquals(5, $site[0]->fresh()->ranking);
        $this->assertEquals(4, $site[1]->fresh()->ranking);
        $this->assertEquals(3, $site[2]->fresh()->ranking);
    }

    /** @test */
    public function can_delete_an_site()
    {
        $site = factory(Site::class)->create();

        $response = $this->delete('/admin/sites/' . $site->id);

        $response->assertRedirect('/admin/sites');
        $this->assertNull($site->fresh());
    }
}
