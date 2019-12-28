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
    public function can_visit_siteFooter_settings_page()
    {
        $response = $this->get('/admin/settings/siteFooter');

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
            'email2' => 'company email2',
            'line_id' => 'line id',
            'fb_url' => 'fb weblink',
            'pikebon_url' => 'pikebon url',
            'twitter_url' => 'twitter url',
            'google_plus_url' => 'google_plus url',
            'pinterest_url' => 'pinterest url',
            'youtube_url' => 'youtube url',
            'instagram_url' => 'instagram url',

            'declare' => 'declare',
            'declare_en' => 'declare_en'
        ];

        $response = $this->patch('/admin/settings/siteFooter', $data);

        $webConfig = WebConfig::firstOrCreate();
        $response->assertRedirect('/admin/settings/siteFooter');

        $this->assertEquals('telephone number', $webConfig->tel);
        $this->assertEquals('fax number', $webConfig->fax);
        $this->assertEquals('company email', $webConfig->email);
        $this->assertEquals('company email2', $webConfig->email2);
        $this->assertEquals('line id', $webConfig->line_id);
        $this->assertEquals('fb weblink', $webConfig->fb_url);
        $this->assertEquals('pikebon url', $webConfig->pikebon_url);
        $this->assertEquals('twitter url', $webConfig->twitter_url);
        $this->assertEquals('pikebon url', $webConfig->pikebon_url);
        $this->assertEquals('google_plus url', $webConfig->google_plus_url);
        $this->assertEquals('pinterest url', $webConfig->pinterest_url);
        $this->assertEquals('youtube url', $webConfig->youtube_url);
        $this->assertEquals('instagram url', $webConfig->instagram_url);
        $this->assertEquals('declare', $webConfig->declare);
        $this->assertEquals('declare_en', $webConfig->declare_en);
    }

    /** @test */
    public function can_visit_googleMap_settings_page()
    {
        $response = $this->get('/admin/settings/googleMap');

        $response->assertSuccessful()
            ->assertSee('Google地圖')
            ->assertSee('地址');
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
    public function can_update_googleMap_setting()
    {
        $data = [
            'address' => 'A super address',
            'address_en' => 'A super addressEnglish',
            'address2' => 'A second super address',
            'address2_en' => 'A second super addressEnglish',
        ];

        $response = $this->patch('/admin/settings/googleMap', $data);

        $webConfig = WebConfig::firstOrCreate();
        $response->assertRedirect('/admin/settings/googleMap');

        $this->assertEquals('A super address', $webConfig->address);
        $this->assertEquals('A super addressEnglish', $webConfig->address_en);
        $this->assertEquals('A second super address', $webConfig->address2);
        $this->assertEquals('A second super addressEnglish', $webConfig->address2_en);
    }


    /** @test */
    public function can_update_pageInfo_setting()
    {
        $data = [
            'title' => 'A super title',
            'keywords' => 'A set of super keywords',
            'description' => 'Some crazy description',
            'meta' => 'Meta',
            'title_en' => 'English super title',
            'keywords_en' => 'English super keywords',
            'description_en' => 'English crazy description',
            'meta_en' => 'English Meta',
        ];

        $response = $this->patch('/admin/settings/pageInfo', $data);

        $webConfig = WebConfig::firstOrCreate();
        $response->assertRedirect('/admin/settings/pageInfo');

        $this->assertEquals('A super title', $webConfig->title);
        $this->assertEquals('A set of super keywords', $webConfig->keywords);
        $this->assertEquals('Some crazy description', $webConfig->description);
        $this->assertEquals('Meta', $webConfig->meta);

        $this->assertEquals('English super title', $webConfig->title_en);
        $this->assertEquals('English super keywords', $webConfig->keywords_en);
        $this->assertEquals('English crazy description', $webConfig->description_en);
        $this->assertEquals('English Meta', $webConfig->meta_en);
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
