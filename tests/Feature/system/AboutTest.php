<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\About;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AboutTest extends TestCase
{
    use DatabaseMigrations;

    function setUp()
    {
        parent::setUp();
        $this->actingAs(factory(User::class)->make());
    }

    /** @test */
    public function can_visit_list_page()
    {
        $about = factory(About::class)->create();

        $response = $this->get('/admin/abouts');

        $response->assertSuccessful()
            ->assertSee('公司簡介管理')
            ->assertSee($about->title);
    }

    /** @test */
    public function can_visit_create_page()
    {
        $response = $this->get('/admin/abouts/create');

        $response->assertSuccessful()
            ->assertSee('新增/修改資料')
            ->assertSee('公司簡介');
    }

    /** @test */
    public function can_visit_edit_page()
    {
        $about = factory(About::class)->create();
        $response = $this->get('/admin/abouts/' . $about->id . '/edit');

        $response->assertSuccessful()
            ->assertSee('修改資料')
            ->assertSee('公司簡介')
            ->assertSee($about->title);
    }

    /** @test */
    public function can_create_a_new_about()
    {
        $newAboutInfo = [
            'title' => 'ANewAbout',
            'published' => true,
            'body' => 'SomeContent Body',
            'photoCtrl' => 'newFile',
            'photo' => UploadedFile::fake()->image('photo.jpg'),
        ];

        $response = $this->post('admin/abouts', $newAboutInfo);

        $response->assertRedirect('admin/abouts');

        tap(About::first(), function ($about) {
            $this->assertEquals('ANewAbout', $about->title);
            $this->assertEquals('SomeContent Body', $about->body);
            $this->assertEquals(true, $about->published);
            $this->assertNotNull($about->ranking);
            $this->assertSame(1, (int)$about->ranking);
            $this->assertNotNull($about->photoPath);
            $this->assertFileExists(public_path('storage/' . $about->photoPath));
        });
    }

    /** @test */
    public function no_photo_file_is_created_if_no_newFile_command_given()
    {
        $newAboutInfo = [
            'title' => 'ANewAbout',
            'published' => true,
            'body' => 'SomeContent Body',
            'photoCtrl' => '',
            'photo' => UploadedFile::fake()->image('photo.jpg'),
        ];

        $response = $this->post('admin/abouts', $newAboutInfo);

        $about = About::first();
        $response->assertRedirect('admin/abouts');
        $this->assertNull($about->photoPath);
    }

    /** @test */
    public function can_update_an_existing_about()
    {
        $about = factory(About::class)->create();
        $newAboutInput = [
            'title' => 'NewTitle',
            'published' => false,
            'body' => 'NewBody',
            'photoCtrl' => 'newFile',
            'photo' => UploadedFile::fake()->image('photo1.jpg'),
        ];

        $response = $this->patch('/admin/abouts/' . $about->id, $newAboutInput);

        $about = $about->fresh();
        $response->assertRedirect('admin/abouts');
        $this->assertEquals('NewTitle', $about->title);
        $this->assertEquals('NewBody', $about->body);
        $this->assertEquals(false, $about->published);
        $this->assertEquals(0, $about->rank);
        $this->assertNotNull($about->photoPath);
        $this->assertFileExists(public_path('storage/' . $about->photoPath));

        //update again with a new photo
        $firstPhotoPath = $about->photoPath;
        $newAboutInput = [
            'title' => 'NewTitle',
            'published' => false,
            'body' => 'NewBody',
            'photoCtrl' => 'newFile',
            'photo' => UploadedFile::fake()->image('photo1.jpg'),
        ];

        $response = $this->patch('/admin/abouts/' . $about->id, $newAboutInput);

        $about = $about->fresh();
        $response->assertRedirect('admin/abouts');
        $this->assertNotNull($about->photoPath);
        $this->assertFileExists(public_path('storage/' . $about->photoPath));
        $this->assertFileNotExists(public_path('storage/' . $firstPhotoPath));


        //update again with a new photo
        $secondPhotoPath = $about->photoPath;
        $newAboutInput = [
            'title' => 'NewTitle',
            'published' => false,
            'body' => 'NewBody',
            'photoCtrl' => 'deleteFile',
            'photo' => UploadedFile::fake()->image('photo1.jpg'),
        ];

        $response = $this->patch('/admin/abouts/' . $about->id, $newAboutInput);
        $about = $about->fresh();
        $response->assertRedirect('admin/abouts');
        $this->assertNull($about->photoPath);
        $this->assertFileNotExists(public_path('storage/' . $secondPhotoPath));
    }

    /** @test */
    public function can_copy_an_about()
    {
        $about = factory(About::class)->create();

        $response = $this->get('/admin/abouts/' . $about->id . '/copy');

        $response->assertSuccessful()
            ->assertSee('修改資料')
            ->assertSee('公司管理')
            ->assertSee($about->title . '(複製)');
    }

    /** @test */
    public function can_update_ranking()
    {
        $abouts = factory(About::class, 3)->create();
        $rankingInput = [
            'id' => [$abouts[0]->id, $abouts[1]->id, $abouts[2]->id],
            'ranking' => [5, 4, 3]
        ];

        $response = $this->patch('/admin/abouts/ranking', $rankingInput);

        $response->assertRedirect('/admin/abouts');
        $this->assertEquals(5, $abouts[0]->fresh()->ranking);
        $this->assertEquals(4, $abouts[1]->fresh()->ranking);
        $this->assertEquals(3, $abouts[2]->fresh()->ranking);
    }

    /** @test */
    public function can_delete_many_abouts_at_one_time()
    {
        $abouts = factory(About::class, 5)->create();
        $input = [
            'chosen_id' => [
                $abouts[0]->id,
                $abouts[2]->id,
                $abouts[4]->id],
            'action' => 'delete'
        ];

        $response = $this->patch('/admin/abouts/action', $input);

        $response->assertSuccessful();
        $this->assertNull($abouts[0]->fresh());
        $this->assertNotNull($abouts[1]->fresh());
        $this->assertNull($abouts[2]->fresh());
        $this->assertNotNull($abouts[3]->fresh());
        $this->assertNull($abouts[4]->fresh());
    }

    /** @test */
    public function can_delete_an_about()
    {
        $about = factory(About::class)->create();

        $response = $this->delete('/admin/abouts/' . $about->id);

        $response->assertRedirect('/admin/abouts');
        $this->assertNull($about->fresh());
    }

    /** @test */
    public function can_set_published_for_many_abouts_at_one_time()
    {
        $abouts = factory(About::class, 3)->create(['published' => false]);
        $abouts->each(function ($about) {
            $this->assertFalse($about->published);
        });
        $input = [
            'chosen_id' => [
                $abouts[0]->id,
                $abouts[2]->id
            ],
            'action' => 'setToShow'
        ];

        $response = $this->patch('/admin/abouts/action', $input);

        $response->assertSuccessful();
        $this->assertTrue($abouts[0]->fresh()->published);
        $this->assertFalse($abouts[1]->fresh()->published);
        $this->assertTrue($abouts[2]->fresh()->published);
    }

    /** @test */
    public function can_set_noShow_for_many_abouts_at_one_time()
    {
        $abouts = factory(About::class, 3)->create(['published' => true]);
        $abouts->each(function ($about) {
            $this->assertTrue($about->published);
        });
        $input = [
            'chosen_id' => [
                $abouts[0]->id,
                $abouts[2]->id
            ],
            'action' => 'setToNoShow'
        ];

        $response = $this->patch('/admin/abouts/action', $input);

        $response->assertSuccessful();
        $this->assertFalse($abouts[0]->fresh()->published);
        $this->assertTrue($abouts[1]->fresh()->published);
        $this->assertFalse($abouts[2]->fresh()->published);
    }

    /** @test */
    public function published_is_required_to_create_an_new_about()
    {
        $this->withExceptionHandling();

        $newAboutInfo = [
            'title' => 'ANewAbout',
        ];

        $response = $this->post('admin/abouts', $newAboutInfo);

        $this->assertValidationError($response, 'published');
    }

    /** @test */
    public function published_should_be_boolean_when_creating_an_about()
    {
        $this->withExceptionHandling();

        $newAboutInfo = [
            'title' => 'ANewAbout',
            'published' => 'notABoolean',
            'body' => 'SomeContent Body'
        ];

        $response = $this->post('admin/abouts', $newAboutInfo);

        $this->assertValidationError($response, 'published');
    }

    /** @test */
    public function published_is_required_to_update_an_about()
    {
        $this->withExceptionHandling();

        $about = factory(About::class)->create();
        $newAboutInfo = [
            'title' => '123',
            'body' => 'body'
        ];

        $response = $this->patch('/admin/abouts/' . $about->id, $newAboutInfo);
        $this->assertValidationError($response, 'published');
    }

    /** @test */
    public function published_should_be_boolean_when_updating_an_about()
    {
        $this->withExceptionHandling();

        $about = factory(About::class)->create();
        $newAboutInfo = [
            'title' => 'ANewAbout',
            'published' => 'notABoolean',
            'body' => 'SomeContent Body'
        ];

        $response = $this->patch('/admin/abouts/' . $about->id, $newAboutInfo);
        $this->assertValidationError($response, 'published');
    }
}
