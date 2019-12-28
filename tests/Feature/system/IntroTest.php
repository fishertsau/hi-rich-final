<?php

namespace Tests\Feature\system;

use App\Models\WebConfig;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IntroTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_visit_intro_edit_page()
    {
        $this->signIn();
        $response = $this->get('/admin/intro');

        $response->assertSuccessful()
            ->assertViewIs('system.intro.edit')
            ->assertSee('首頁簡介');
    }


    /** @test */
    public function can_update_company_intro()
    {
        $this->signIn();

        $response = $this->patch('/admin/intro', [
            'intro_title' => 'introTitle',
            'intro_subTitle' => 'introSubTitle',
            'intro' => 'Company Introduction',
            'intro_en' => 'English Company Introduction',
        ]);

        $response->assertRedirect('/admin');

        $webConfig = WebConfig::firstOrCreate();
        $this->assertEquals('introTitle', $webConfig->intro_title);
        $this->assertEquals('introSubTitle', $webConfig->intro_subTitle);
        $this->assertEquals('Company Introduction', $webConfig->intro);
        $this->assertEquals('English Company Introduction', $webConfig->intro_en);
    }
}
