<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Inquiry;
use App\Models\WebConfig;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class InquiryTest extends TestCase
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
        $inquiry = $this->create(Inquiry::class,['company_name' => 'CompanyName']);

        $response = $this->get('/admin/inquiries');

        $response->assertSuccessful()
            ->assertSee('詢價信件管理')
            ->assertSee($inquiry->company_name);
    }


    /** @test */
    public function can_see_detail_from_admin()
    {
        $inquiry = $this->create(Inquiry::class);

        $response = $this->get('/admin/inquiries/' . $inquiry->id);

        $response->assertSuccessful()
            ->assertSee('詢價信件管理')
            ->assertSee($inquiry->subject);
    }


    /** @test */
    public function can_delete_an_inquiry_from_admin()
    {
        $inquiry = $this->create(Inquiry::class);

        $response = $this->delete('/admin/inquiries/' . $inquiry->id);

        $response->assertRedirect('/admin/inquiries');
        $this->assertNull($inquiry->fresh());
    }

    /** @test */
    public function can_visit_inquiry_config_page_from_admin()
    {
        $response = $this->get('/admin/inquiries/config');

        $response->assertSuccessful()
            ->assertSee('聯絡資訊管理');
    }

    /** @test */
    public function can_visit_inquiry_template_setting_page()
    {
        $response = $this->get('/admin/inquiries/template');

        $response->assertSuccessful()
            ->assertSee('送出頁管理');
    }

    /** @test */
    public function can_update_inquiry_template_settings()
    {
        $data = [
            'inquiry_info' => 'Inquiry Info',
            'inquiry_info_en' => 'English Inquiry Info',
        ];

        $response = $this->patch('/admin/inquiries/template', $data);

        $response->assertRedirect('/admin/inquiries/template');

        tap(WebConfig::firstOrCreate(),function($webConfig){
            $this->assertEquals('Inquiry Info', $webConfig->inquiry_info);
            $this->assertEquals('English Inquiry Info', $webConfig->inquiry_info_en);
        });
    }




    /** @test */
    public function can_set_an_inquiry_as_processed()
    {
        $inquiry = $this->create(Inquiry::class);

        $this->assertFalse($inquiry->fresh()->processed);
        $response = $this
            ->post('/admin/inquiries/' . $inquiry->id . '/processed');

        $response->assertJson([
            'status' => 'success',
            'message' => 'An Inquiry is set to processed.'
        ]);

        $this->assertTrue($inquiry->fresh()->processed);
    }
}
