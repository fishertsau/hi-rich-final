<?php

namespace Tests\Feature\system;

use Tests\TestCase;
use App\Models\WebConfig;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GearIntroTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_visit_gear_intro_edit_page()
    {
        $this->signIn();
        $response = $this->get('/admin/gearIntro');

        $response->assertSuccessful()
            ->assertViewIs('system.gearIntro.edit');
    }


    /** @test */
    public function can_update_gear_intro()
    {
        $this->signIn();

        $response = $this->patch('/admin/gearIntro', [
            'gear_intro' => 'Gear Introduction',
            'gear_intro_en' => 'English Gear Introduction'
        ]);

        $response->assertRedirect('/admin');

        $webConfig = WebConfig::firstOrCreate();
        $this->assertEquals('Gear Introduction', $webConfig->gear_intro);
        $this->assertEquals('English Gear Introduction', $webConfig->gear_intro_en);
    }
}
