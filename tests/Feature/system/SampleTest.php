<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Sample;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SampleTest extends TestCase
{
    use DatabaseMigrations;

    function setUp()
    {
        parent::setUp();
        $this->actingAs(factory(User::class)->make());
    }


    private function params($data = [])
    {
        $newSampleInfo = [
            'title' => 'ANewSample',
            'published' => true,
            'body' => 'SomeContent Body',
            'description' => 'SomeDescription',
            'photoCtrl' => 'newFile',
            'photo' => UploadedFile::fake()->create('photo.jpg'),
        ];

        return array_merge($newSampleInfo, $data);
    }


    /** @test */
    public function can_visit_list_page()
    {
        $sample = factory(Sample::class)->create();

        $response = $this->get('/admin/samples');

        $response->assertSuccessful()
            ->assertSee('安裝實例管理')
            ->assertSee($sample->title);
    }

    /** @test */
    public function can_visit_create_page()
    {
        $response = $this->get('/admin/samples/create');

        $response->assertSuccessful()
            ->assertSee('新增實例')
            ->assertSee('安裝實例管理');
    }


    /** @test */
    public function can_visit_edit_page()
    {
        $sample = factory(Sample::class)->create();
        $response = $this->get('/admin/samples/' . $sample->id . '/edit');

        $response->assertSuccessful()
            ->assertSee('修改實例')
            ->assertSee('安裝實例管理')
            ->assertSee($sample->title);
    }


    /** @test */
    public function can_create_a_new_sample()
    {
        $newSampleInfo = [
            'title' => 'ANewSample',
            'published' => true,
            'body' => 'SomeContent Body',
            'description' => 'SomeDescription',
            'photoCtrl' => 'newFile',
            'photo' => UploadedFile::fake()->create('photo.jpg'),
        ];

        $response = $this->post('admin/samples', $newSampleInfo);

        $sample = Sample::first();
        $response->assertRedirect('admin/samples');
        $this->assertEquals('ANewSample', $sample->title);
        $this->assertEquals('SomeContent Body', $sample->body);
        $this->assertEquals('SomeDescription', $sample->description);
        $this->assertEquals(true, $sample->published);
        $this->assertNotNull($sample->photoPath);
        $this->assertFileExists(public_path('storage/' . $sample->photoPath));
        $this->assertNotNull($sample->ranking);
        $this->assertSame(0, (int)$sample->ranking);
    }


    /** @test */
    public function can_update_an_existing_sample()
    {
        $sample = factory(Sample::class)->create();
        $newSampleInput = [
            'title' => 'NewTitle',
            'published' => false,
            'body' => 'NewBody',
            'description' => 'SuperSuperNewDescription',
            'photoCtrl' => 'newFile',
            'photo' => UploadedFile::fake()->create('photo.jpg'),
        ];

        $response = $this->patch('/admin/samples/' . $sample->id, $this->params($newSampleInput));

        $sample = $sample->fresh();
        $response->assertRedirect('admin/samples');
        $this->assertEquals('NewTitle', $sample->title);
        $this->assertEquals('NewBody', $sample->body);
        $this->assertEquals('SuperSuperNewDescription', $sample->description);
        $this->assertEquals(false, $sample->published);
        $this->assertEquals(0, $sample->rank);
        $this->assertNotNull($sample->photoPath);
        $this->assertFileExists(public_path('storage/' . $sample->photoPath));

        //update again with a new photo
        $firstPhotoPath = $sample->photoPath;
        $updatedSampleInfo = [
            'photoCtrl' => 'newFile',
            'photo' => UploadedFile::fake()->create('photo2.jpg'),
        ];

        $response = $this->patch('/admin/samples/' . $sample->id, $this->params($updatedSampleInfo));

        $sample = $sample->fresh();
        $response->assertRedirect('admin/samples');
        $this->assertNotNull($sample->photoPath);
        $this->assertFileExists(public_path('storage/' . $sample->photoPath));
        $this->assertFileNotExists(public_path('storage/' . $firstPhotoPath));


        //update again to delete photo
        $secondPhotoPath = $sample->photoPath;

        $updatedSampleInfo = [
            'photoCtrl' => 'deleteFile',
            'photo' => UploadedFile::fake()->create('photo2.jpg'),
        ];

        $this->patch('/admin/samples/' . $sample->id, $this->params($updatedSampleInfo));


        $sample = $sample->fresh();
        $this->assertFileNotExists(public_path('storage\\' . $secondPhotoPath));
        $this->assertNull($sample->photoPath);
    }

    /** @test */
    public function no_photo_is_created_if_no_newFile_command_is_given()
    {
        $newSampleInfo = [
            'photoCtrl' => '',
            'photo' => UploadedFile::fake()->create('photo.jpg'),
        ];

        $response = $this->post('admin/samples', $this->params($newSampleInfo));

        $sample = Sample::first();
        $response->assertRedirect('admin/samples');
        $this->assertNull($sample->photoPath);
    }

    /** @test */
    public function can_copy_a_sample()
    {
        $sample = factory(Sample::class)->create();

        $response = $this->get('/admin/samples/' . $sample->id . '/copy');

        $response->assertSuccessful()
            ->assertSee('複製實例')
            ->assertSee('安裝實例管理')
            ->assertSee($sample->title)
            ->assertSee('(複製)')
            ->assertSee($sample->body);
    }


    /** @test */
    public function can_update_ranking()
    {
        $samples = factory(Sample::class, 3)->create();
        $rankingInput = [
            'id' => [$samples[0]->id, $samples[1]->id, $samples[2]->id],
            'ranking' => [5, 4, 3]
        ];

        $response = $this->patch('/admin/samples/ranking', $rankingInput);

        $response->assertRedirect('/admin/samples');
        $this->assertEquals(5, $samples[0]->fresh()->ranking);
        $this->assertEquals(4, $samples[1]->fresh()->ranking);
        $this->assertEquals(3, $samples[2]->fresh()->ranking);
    }


    /** @test */
    public function can_delete_many_samples_at_one_time()
    {
        $samples = factory(Sample::class, 5)->create();
        $input = [
            'chosen_id' => [
                $samples[0]->id,
                $samples[2]->id,
                $samples[4]->id],
            'action' => 'delete'
        ];

        $response = $this->patch('/admin/samples/action', $input);

        $response->assertSuccessful();
        $this->assertNull($samples[0]->fresh());
        $this->assertNotNull($samples[1]->fresh());
        $this->assertNull($samples[2]->fresh());
        $this->assertNotNull($samples[3]->fresh());
        $this->assertNull($samples[4]->fresh());
    }

    /** @test */
    public function can_delete_an_sample()
    {
        $sample = factory(Sample::class)->create();

        $response = $this->delete('/admin/samples/' . $sample->id);

        $response->assertRedirect('/admin/samples');
        $this->assertNull($sample->fresh());
    }


    /** @test */
    public function can_set_published_for_many_samples_at_one_time()
    {
        $samples = factory(Sample::class, 3)->create(['published' => false]);
        $samples->each(function ($sample) {
            $this->assertFalse($sample->published);
        });
        $input = [
            'chosen_id' => [
                $samples[0]->id,
                $samples[2]->id
            ],
            'action' => 'setToShow'
        ];

        $response = $this->patch('/admin/samples/action', $input);

        $response->assertSuccessful();
        $this->assertTrue($samples[0]->fresh()->published);
        $this->assertFalse($samples[1]->fresh()->published);
        $this->assertTrue($samples[2]->fresh()->published);
    }

    /** @test */
    public function can_set_noShow_for_many_samples_at_one_time()
    {
        $samples = factory(Sample::class, 3)->create(['published' => true]);
        $samples->each(function ($sample) {
            $this->assertTrue($sample->published);
        });
        $input = [
            'chosen_id' => [
                $samples[0]->id,
                $samples[2]->id
            ],
            'action' => 'setToNoShow'
        ];

        $response = $this->patch('/admin/samples/action', $input);

        $response->assertSuccessful();
        $this->assertFalse($samples[0]->fresh()->published);
        $this->assertTrue($samples[1]->fresh()->published);
        $this->assertFalse($samples[2]->fresh()->published);
    }


    /** @test */
    public function title_is_required_to_create_an_new_sample()
    {
        $this->withExceptionHandling();
        $newSampleInfo = [
            'published' => true,
            'body' => 'SomeContent Body'
        ];

        $response = $this->post('admin/samples', $newSampleInfo);

        $this->assertValidationError($response, 'title');
    }


    /** @test */
    public function published_is_required_to_create_an_new_sample()
    {
        $this->withExceptionHandling();

        $newSampleInfo = [
            'title' => 'ANewSample',
        ];

        $response = $this->post('admin/samples', $newSampleInfo);

        $this->assertValidationError($response, 'published');
    }

    /** @test */
    public function published_should_be_boolean_when_creating_an_sample()
    {
        $this->withExceptionHandling();

        $newSampleInfo = [
            'title' => 'ANewSample',
            'published' => 'notABoolean',
            'body' => 'SomeContent Body'
        ];

        $response = $this->post('admin/samples', $newSampleInfo);

        $this->assertValidationError($response, 'published');
    }


    /** @test */
    public function title_is_required_to_update_an_sample()
    {
        $this->withExceptionHandling();

        $sample = factory(Sample::class)->create();
        $newSampleInfo = [
            'published' => true,
            'body' => 'SomeContent Body'
        ];

        $response = $this->patch('/admin/samples/' . $sample->id, $newSampleInfo);
        $this->assertValidationError($response, 'title');
    }


    /** @test */
    public function published_is_required_to_update_an_sample()
    {
        $this->withExceptionHandling();

        $sample = factory(Sample::class)->create();
        $newSampleInfo = [
            'title' => '123',
            'body' => 'body'
        ];

        $response = $this->patch('/admin/samples/' . $sample->id, $newSampleInfo);
        $this->assertValidationError($response, 'published');
    }

    /** @test */
    public function published_should_be_boolean_when_updating_an_sample()
    {
        $this->withExceptionHandling();

        $sample = factory(Sample::class)->create();
        $newSampleInfo = [
            'title' => 'ANewSample',
            'published' => 'notABoolean',
            'body' => 'SomeContent Body'
        ];

        $response = $this->patch('/admin/samples/' . $sample->id, $newSampleInfo);
        $this->assertValidationError($response, 'published');
    }
}
