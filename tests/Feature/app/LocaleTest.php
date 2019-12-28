<?php

namespace Tests\Feature;

use App;
use Tests\TestCase;

class LocaleTest extends TestCase
{
    /** @test */
    public function the_default_language_is_chinese()
    {
        $this->assertEquals('zh-TW', App::getLocale());
    }


    /** @test */
    public function can_change_language_from_english_to_chinese()
    {
        $this->assertNotEquals('zh-TW', session('locale'));

        $response = $this->from('inquiries')->get('/locale/zh-TW');

        $response->assertRedirect('inquiries');
        $this->assertEquals('zh-TW', session('locale'));
    }


    /** @test */
    public function can_change_language_from_chinese_to_english()
    {
        $this->assertNotEquals('en', session('locale'));

        $response = $this->from('inquiries')->get('/locale/en');

        $response->assertRedirect('inquiries');
        $this->assertEquals('en', session('locale'));
    }
}
