<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\WebConfig;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SiteSettingsTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;

    function setUp()
    {
        parent::setUp();
        $this->actingAs(factory(User::class)->make());
    }

    /** @test */
    public function can_visit_companyInfo_settings_page()
    {
        $response = $this->get('/admin/settings/companyInfo');

        $response->assertSuccessful()
            ->assertSee('編輯資料')
            ->assertSee('地址')
            ->assertSee('電話')
            ->assertSee('傳真')
            ->assertSee('電子信箱');
    }

    /** @test */
    public function can_update_site_footer_setting()
    {
        $data = [
            'tel' => 'telephone number',
            'fax' => 'fax number',
            'email' => 'company email',
        ];

        $response = $this->patch('/admin/settings/companyInfo', $data);

        $webConfig = WebConfig::firstOrCreate();
        $response->assertRedirect('/admin/settings/companyInfo');

        $this->assertEquals('telephone number', $webConfig->tel);
        $this->assertEquals('fax number', $webConfig->fax);
        $this->assertEquals('company email', $webConfig->email);
    }

    /** @test */
    public function can_visit_pageInfo_settings_page()
    {
        $response = $this->get('/admin/settings/pageInfo');

        $response->assertSuccessful()
            ->assertSee('網站頁面標題')
            ->assertSee('網站頁面關鍵字')
            ->assertSee('網站頁面描述')
            ->assertSee('Meta');
    }

    /** @test */
    public function can_update_pageInfo_setting()
    {
        $data = [
            'title' => 'A super title',
            'keywords' => 'A set of super keywords',
            'description' => 'Some crazy description',
            'meta' => 'Meta',
        ];

        $response = $this->patch('/admin/settings/pageInfo', $data);

        $webConfig = WebConfig::firstOrCreate();
        $response->assertRedirect('/admin/settings/pageInfo');

        $this->assertEquals('A super title', $webConfig->title);
        $this->assertEquals('A set of super keywords', $webConfig->keywords);
        $this->assertEquals('Some crazy description', $webConfig->description);
        $this->assertEquals('Meta', $webConfig->meta);
    }

    /** @test */
    public function can_visit_mailService_settings_page()
    {
        $response = $this->get('/admin/settings/mailService');

        $response->assertSuccessful()
            ->assertSee('信件設定')
            ->assertSee('系統服務名稱')
            ->assertSee('郵件服務接收信箱');
    }

    /** @test */
    public function can_update_mailService_setting()
    {
        $data = [
            'mail_service_provider' => 'A service provider',
            'mail_receivers' => 'some receivers'
        ];

        $response = $this->patch('/admin/settings/mailService', $data);

        $webConfig = WebConfig::firstOrCreate();
        $response->assertRedirect('/admin/settings/mailService');

        $this->assertEquals('A service provider', $webConfig->mail_service_provider);
        $this->assertEquals('some receivers', $webConfig->mail_receivers);
    }
}
