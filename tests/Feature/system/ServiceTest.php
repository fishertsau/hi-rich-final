<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Service;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;

    function setUp()
    {
        parent::setUp();
        $this->actingAs(factory(User::class)->make());
    }

    /** @test */
    public function can_visit_list_page()
    {
        $response = $this->get('/admin/services');

        $response->assertViewIs('system.service.index');
    }

    /** @test */
    public function can_visit_create_page()
    {
        $response = $this->get('/admin/services/create');

        $response
            ->assertSuccessful()
            ->assertSee('服務項目管理');

        $response->assertViewIs('system.service.create');
    }


    /** @test */
    public function can_visit_edit_page()
    {
        $service = factory(Service::class)->create();
        $response = $this->get('/admin/services/' . $service->id . '/edit');

        $response->assertSuccessful()
            ->assertSee($service->title);
    }

    /** @test */
    public function can_create_a_new_service_from_admin()
    {
        $newServiceInfo = [
            'published' => true,
            'published_in_home' => true,
            'title' => 'ANewService',
            'title_en' => 'ANewServiceEnglish',
            'briefing' => 'ANewServiceBriefing',
            'briefing_en' => 'ANewServiceBriefingEnglish',
            'body' => 'SomeContent Body',
            'body_en' => 'SomeContent BodyEnglish',
            'photoCtrl' => 'newFile',
            'photo' => UploadedFile::fake()->image('photo.jpg'),
        ];

        $response = $this->post('admin/services', $newServiceInfo);

        $this->assertCount(1, Service::all());

        $service = Service::first();
        $response->assertRedirect('admin/services');
        $this->assertEquals(true, $service->published);
        $this->assertEquals(true, $service->published_in_home);
        $this->assertEquals('ANewService', $service->title);
        $this->assertEquals('ANewServiceEnglish', $service->title_en);
        $this->assertEquals('SomeContent Body', $service->body);
        $this->assertEquals('SomeContent BodyEnglish', $service->body_en);
        $this->assertNotNull($service->ranking);
        $this->assertSame(0, (int)$service->ranking);
        $this->assertNotNull($service->photoPath);
        $this->assertFileExists(public_path('storage/' . $service->photoPath));
    }


    /** @test */
    public function no_photo_or_pdf_file_is_created_if_no_newFile_command_is_given()
    {
        $newServiceInfo = [
            'published' => true,
            'published_in_home' => true,
            'title' => 'ANewService',
            'body' => 'SomeContent Body',
            'photoCtrl' => '',
            'photo' => UploadedFile::fake()->image('photo.jpg'),
        ];

        $response = $this->post('admin/services', $newServiceInfo);

        $service = Service::first();
        $response->assertRedirect('admin/services');
        $this->assertNull($service->photoPath);
    }


    /** @test */
    public function can_update_an_existing_service_from_admin()
    {
        $service = factory(Service::class)->create();
        $newServiceInfo = [
            'published' => true,
            'published_in_home' => false,
            'title' => 'ANewTitle',
            'body' => 'SomeNewContent Body',
            'photoCtrl' => 'newFile',
            'photo' => UploadedFile::fake()->image('photo.jpg'),
        ];

        $response = $this->patch('/admin/services/' . $service->id, $newServiceInfo);

        $service = $service->fresh();
        $response->assertRedirect('admin/services');
        $this->assertEquals(true, $service->published);
        $this->assertEquals(false, $service->published_in_home);
        $this->assertEquals('ANewTitle', $service->title);
        $this->assertEquals('SomeNewContent Body', $service->body);
        $this->assertEquals($service->ranking, (int)$service->ranking);
        $this->assertNotNull($service->photoPath);
        $this->assertFileExists(public_path('storage/' . $service->photoPath));


        //update again with a new photo
        $firstPhotoPath = $service->photoPath;

        $updatedServiceInfo = [
            'published' => true,
            'published_in_home' => false,
            'title' => 'ANewTitle',
            'body' => 'SomeNewContent Body',
            'photoCtrl' => 'newFile',
            'photo' => UploadedFile::fake()->image('photo2.jpg'),
        ];
        $response = $this->patch('/admin/services/' . $service->id, $updatedServiceInfo);

        $service = $service->fresh();
        $response->assertRedirect('admin/services');
        $this->assertNotNull($service->photoPath);
        $this->assertFileExists(public_path('storage/' . $service->photoPath));
        $this->assertFileNotExists(public_path('storage/' . $firstPhotoPath));

        //update again to delete photo
        $secondPhotoPath = $service->photoPath;
        $updatedServiceInfo = [
            'published' => true,
            'published_in_home' => false,
            'title' => 'ANewTitle',
            'body' => 'SomeNewContent Body',
            'photoCtrl' => 'deleteFile',
            'photo' => UploadedFile::fake()->image('photo3.jpg'),
        ];
        $response = $this->patch('/admin/services/' . $service->id, $updatedServiceInfo);

        $service = $service->fresh();
        $response->assertRedirect('admin/services');
        $this->assertNull($service->photoPath);
        $this->assertFileNotExists(public_path('storage/' . $secondPhotoPath));
    }


    /** @test */
    public function can_copy_a_service_from_admin()
    {
        $service = factory(Service::class)->create();

        $response = $this->get('/admin/services/' . $service->id . '/copy');

        $response->assertSuccessful()
            ->assertSee('服務項目管理')
            ->assertSee('複製服務');
    }


    /** @test */
    public function can_update_ranking_from_admin()
    {
        $services = factory(Service::class, 3)->create();
        $rankingInput = [
            'id' => [$services[0]->id, $services[1]->id, $services[2]->id],
            'ranking' => [5, 4, 3]
        ];

        $response = $this->patch('/admin/services/ranking', $rankingInput);

        $response->assertRedirect('/admin/services');
        $this->assertEquals(5, $services[0]->fresh()->ranking);
        $this->assertEquals(4, $services[1]->fresh()->ranking);
        $this->assertEquals(3, $services[2]->fresh()->ranking);
    }


    /** @test */
    public function can_delete_many_services_at_one_time()
    {
        $services = factory(Service::class, 5)->create();
        $input = [
            'chosen_id' => [
                $services[0]->id,
                $services[2]->id,
                $services[4]->id],
            'action' => 'delete'
        ];

        $response = $this->patch('/admin/services/action', $input);

        $response->assertSuccessful();
        $this->assertNull($services[0]->fresh());
        $this->assertNotNull($services[1]->fresh());
        $this->assertNull($services[2]->fresh());
        $this->assertNotNull($services[3]->fresh());
        $this->assertNull($services[4]->fresh());
    }

    /** @test */
    public function can_delete_a_service()
    {
        $service = factory(Service::class)->create();

        $response = $this->delete('/admin/services/' . $service->id);

        $response->assertRedirect('/admin/services');
        $this->assertNull(Service::find($service->id));
    }


    /** @test */
    public function can_set_published_for_many_services_at_one_time()
    {
        $services = factory(Service::class, 3)->create(['published' => false]);
        $services->each(function ($service) {
            $this->assertFalse($service->published);
        });

        $input = [
            'chosen_id' => [
                $services[0]->id,
                $services[2]->id
            ],
            'action' => 'setToShow'
        ];

        $response = $this->patch('/admin/services/action', $input);

        $response->assertSuccessful();
        $this->assertTrue($services[0]->fresh()->published);
        $this->assertFalse($services[1]->fresh()->published);
        $this->assertTrue($services[2]->fresh()->published);
    }

    /** @test */
    public function can_set_noShow_for_many_services_at_one_time()
    {
        $services = factory(Service::class, 3)->create(['published' => true]);
        $services->each(function ($service) {
            $this->assertTrue($service->published);
        });
        $input = [
            'chosen_id' => [
                $services[0]->id,
                $services[2]->id
            ],
            'action' => 'setToNoShow'
        ];

        $response = $this->patch('/admin/services/action', $input);

        $response->assertSuccessful();
        $this->assertFalse($services[0]->fresh()->published);
        $this->assertTrue($services[1]->fresh()->published);
        $this->assertFalse($services[2]->fresh()->published);
    }

    /** @test */
    public function can_set_show_at_home_for_many_services_at_one_time()
    {
        $services = factory(Service::class, 3)->create(['published_in_home' => false]);
        $services->each(function ($service) {
            $this->assertFalse($service->published_in_home);
        });

        $input = [
            'chosen_id' => [
                $services[0]->id,
                $services[2]->id
            ],
            'action' => 'setToShowAtHome'
        ];

        $response = $this->patch('/admin/services/action', $input);

        $response->assertSuccessful();
        $this->assertTrue($services[0]->fresh()->published_in_home);
        $this->assertFalse($services[1]->fresh()->published_in_home);
        $this->assertTrue($services[2]->fresh()->published_in_home);
    }

    /** @test */
    public function can_set_noShow_at_home_for_many_services_at_one_time()
    {
        $services = factory(Service::class, 3)->create(['published_in_home' => true]);
        $services->each(function ($service) {
            $this->assertTrue($service->published_in_home);
        });
        $input = [
            'chosen_id' => [
                $services[0]->id,
                $services[2]->id
            ],
            'action' => 'setToNoShowAtHome'
        ];

        $response = $this->patch('/admin/services/action', $input);

        $response->assertSuccessful();
        $this->assertFalse($services[0]->fresh()->published_in_home);
        $this->assertTrue($services[1]->fresh()->published_in_home);
        $this->assertFalse($services[2]->fresh()->published_in_home);
    }


    /** @test */
    public function published_is_required_to_create_a_new_service()
    {
        $this->withExceptionHandling();
        $newServiceInfo = [
            'published_in_home' => true,
            'cat_id' => 1,
            'title' => 'ANewService',
            'body' => 'SomeContent Body'
        ];

        $response = $this->post('admin/services', $newServiceInfo);

        $this->assertValidationError($response, 'published');
    }

    /** @test */
    public function published_in_home_is_required_to_create_a_new_service()
    {
        $this->withExceptionHandling();
        $newServiceInfo = [
            'published' => true,
            'cat_id' => 1,
            'title' => 'ANewService',
            'body' => 'SomeContent Body'
        ];

        $response = $this->post('admin/services', $newServiceInfo);

        $this->assertValidationError($response, 'published_in_home');
    }




    /** @test */
    public function published_should_be_boolean_when_creating_a_service()
    {
        $this->withExceptionHandling();
        $newServiceInfo = [
            'published' => 'published',
            'published_in_home' => true,
            'cat_id' => 1,
            'title' => 'ANewService',
            'body' => 'SomeContent Body'
        ];

        $response = $this->post('admin/services', $newServiceInfo);

        $this->assertValidationError($response, 'published');
    }

    /** @test */
    public function published_in_home_should_be_boolean_when_creating_a_service()
    {
        $this->withExceptionHandling();
        $newServiceInfo = [
            'published' => true,
            'published_in_home' => 'true',
            'title' => 'ANewService',
            'body' => 'SomeContent Body'
        ];

        $response = $this->post('admin/services', $newServiceInfo);

        $this->assertValidationError($response, 'published_in_home');
    }

    /** @test */
    public function published_is_required_to_update_a_service()
    {
        $this->withExceptionHandling();
        $service = factory(Service::class)->create();
        $newServiceInfo = [
            'published_in_home' => true,
            'title' => 'ANewService',
            'body' => 'SomeContent Body'
        ];

        $response = $this->patch('/admin/services/' . $service->id, $newServiceInfo);
        $this->assertValidationError($response, 'published');
    }

    /** @test */
    public function published_in_home_is_required_to_update_a_service()
    {
        $this->withExceptionHandling();
        $service = factory(Service::class)->create();
        $newServiceInfo = [
            'published' => true,
            'title' => 'ANewService',
            'body' => 'SomeContent Body'
        ];

        $response = $this->patch('/admin/services/' . $service->id, $newServiceInfo);
        $this->assertValidationError($response, 'published_in_home');
    }



    /** @test */
    public function published_should_be_boolean_to_update_a_service()
    {
        $this->withExceptionHandling();
        $service = factory(Service::class)->create();

        $newServiceInfo = [
            'published' => 'published',
            'published_in_home' => true,
            'title' => 'ANewService',
            'body' => 'SomeContent Body'
        ];

        $response = $this->patch('/admin/services/' . $service->id, $newServiceInfo);

        $this->assertValidationError($response, 'published');
    }

    /** @test */
    public function published_in_home_should_be_boolean_to_update_a_service()
    {
        $this->withExceptionHandling();
        $service = factory(Service::class)->create();

        $newServiceInfo = [
            'published' => true,
            'published_in_home' => 'true',
            'title' => 'ANewService',
            'body' => 'SomeContent Body'
        ];

        $response = $this->patch('/admin/services/' . $service->id, $newServiceInfo);

        $this->assertValidationError($response, 'published_in_home');
    }
}
