<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create([
            'name' => 'someAccount',
            'password' => bcrypt('password')
        ]);
    }


    /** @test */
    public function can_visit_login_page()
    {
        $response = $this->get('/login');

        $response->assertSuccessful()
            ->assertSee('後台系統登入');
    }


    /** @test */
    public function can_login_with_preset_account_and_password()
    {
        $loginInfo = [
            'name' => 'someAccount',
            'password' => 'password'
        ];

        $response = $this->post('/login', $loginInfo);

        $response->assertRedirect('/admin');
        $this->assertTrue(auth()->check());
    }


    /** @test */
    public function can_change_password_from_admin()
    {
        $this->actingAs($this->user);

        $newPassInfo = [
            'password' => 'newPassword123',
            'password_confirmation' => 'newPassword123'
        ];

        $response = $this->post('/password/reset', $newPassInfo);

        $response->assertRedirect('admin');

        //logout
        auth()->logout();
        $this->assertFalse(auth()->check());


        //login with new password
        $loginInfo = [
            'name' => 'someAccount',
            'password' => 'newPassword123'
        ];

        $response = $this->post('/login', $loginInfo);

        $response->assertRedirect('/admin');
        $this->assertTrue(auth()->check());
    }

    /** @test */
    public function can_logout()
    {
        $this->actingAs($this->user);
        $this->assertTrue(auth()->check());

        $response = $this->post('logout');

        $response->assertRedirect('/');
        $this->assertFalse(auth()->check());
    }


    /** @test */
    public function redirected_to_login_page_when_unsigned_in_user_tries_to_use_admin()
    {
        $this->withExceptionHandling();
        $response = $this->get('admin');

        $response->assertRedirect('/login');
    }


    /** @test */
    public function name_is_required_to_login()
    {
        $this->withExceptionHandling();
        $loginInfo = [
            'password' => 'password'
        ];

        $response = $this->post('/login', $loginInfo);

        $this->assertValidationError($response, 'name');
    }

    /** @test */
    public function password_is_required_to_login()
    {
        $this->withExceptionHandling();
        $loginInfo = [
            'name' => 'someAccount',
        ];

        $response = $this->post('/login', $loginInfo);
        $this->assertValidationError($response, 'password');
    }


    /** @test */
    public function password_is_required_to_change_password()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user);

        $newPassInfo = [
            'password_confirmation' => 'newPassword'
        ];

        $response = $this->post('/password/reset', $newPassInfo);

        $this->assertValidationError($response, 'password');
    }


    /** @test */
    public function password_confirmation_is_required_to_change_password()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user);

        $newPassInfo = [
            'password' => 'newPassword',
        ];

        $response = $this->post('/password/reset', $newPassInfo);

        $this->assertValidationError($response, 'password');
    }

    /** @test */
    public function password_and_password_confirmation_should_be_the_same_to_change_password()
    {
        $this->withExceptionHandling();
        $this->actingAs($this->user);

        $newPassInfo = [
            'password' => 'newPassword',
            'password_confirmation' => 'wrongNewPassword'
        ];

        $response = $this->post('/password/reset', $newPassInfo);

        $this->assertValidationError($response, 'password');
    }

    /** @test */
    public function a_singed_in_user_is_redirected_when_visiting_login_page()
    {
        $this->actingAs($this->user);

        $response = $this->get('login');

        $response->assertRedirect('/admin');
    }
}
