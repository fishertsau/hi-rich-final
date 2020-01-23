<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Contact;
use App\Models\WebConfig;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ContactTest extends TestCase
{
    use DatabaseMigrations;

    function setUp()
    {
        parent::setUp();
        $this->actingAs(factory(User::class)->make());
    }

    /** @test */
    public function can_visit_list_page_from_admin()
    {
        $response = $this->get('/admin/contacts');

        $response->assertSuccessful()
            ->assertSee('聯絡表單管理');
    }


    /** @test */
    public function can_see_detail_from_admin()
    {
        $contact = $this->create(Contact::class);

        $response = $this->get('/admin/contacts/' . $contact->id);

        $response->assertSuccessful()
            ->assertSee('信件內容');
    }


    /** @test */
    public function can_delete_an_contact_from_admin()
    {
        $contact = $this->create(Contact::class);

        $response = $this->delete('/admin/contacts/' . $contact->id);

        $response->assertRedirect('/admin/contacts');
        $this->assertNull($contact->fresh());
    }

    /** @test */
    public function can_visit_contact_template_setting_page()
    {
        $response = $this->get('/admin/contacts/template');

        $response->assertSuccessful()
            ->assertSee('送出頁管理');
    }

    /** @test */
    public function can_update_contact_template_settings()
    {
        $data = [
            'google_track_code' => 'Google Track Code',
            'google_map' => 'A Google Map',
            'contact_ok' => 'Contact ok page',
            'contact_ok_en' => 'English Contact ok page',
        ];

        $response = $this->patch('/admin/contacts/template', $data);
        $response->assertRedirect('/admin/contacts/template');

        tap(WebConfig::firstOrCreate(), function ($webConfig) {
            $this->assertEquals('Contact ok page', $webConfig->contact_ok);
        });
    }


    /** @test */
    public function can_set_an_contact_as_processed()
    {
        $contact = $this->create(Contact::class);

        $this->assertFalse($contact->fresh()->processed);
        $response = $this
            ->post('/admin/contacts/' . $contact->id . '/processed');

        $response->assertJson([
            'status' => 'success',
            'message' => 'An Contact is set to processed.'
        ]);

        $this->assertTrue($contact->fresh()->processed);
    }
}
