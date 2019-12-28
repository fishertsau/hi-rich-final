<?php

namespace Tests;

use Mockery;
use App\User;
use Exception;
use App\Exceptions\Handler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp()
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    protected function signIn($user = null)
    {
        $user = $user ?: factory(User::class)->create();
        $this->actingAs($user);
        return $this;
    }

    protected function assertValidationError($response, $field)
    {
        $response->assertStatus(302);
        $this->assertTrue((session('errors')->getBags()['default'])->has($field));
    }


    public function spy($class)
    {
        $mock = Mockery::spy($class);

        $this->app->instance($class, $mock);

        return $mock;
    }


    public function mock($class)
    {
        $mock = Mockery::mock($class);

        $this->app->instance($class, $mock);

        return $mock;
    }


    protected function create($class, $attributes = [], $times = null)
    {
        return factory($class, $times)->create($attributes);
    }

    protected function make($class, $attributes = [], $times = null)
    {
        return factory($class, $times)->make($attributes);
    }

    protected function makeRaw($class, $attributes = [], $times = null)
    {
        return factory($class, $times)->raw($attributes);
    }

    public function from(string $url)
    {
        session()->setPreviousUrl(url($url));
        return $this;
    }
}

class PassThroughHandler extends Handler
{
    public function __construct()
    {
    }

    public function report(Exception $e)
    {
        // no-op
    }

    public function render($request, Exception $e)
    {
        throw $e;
    }
}

