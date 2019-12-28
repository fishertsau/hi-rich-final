<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Sample;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SampleTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function should_see_the_list_ordered_by_ranking()
    {
        for ($i = 0; $i < 10; $i++) {
            factory(Sample::class)->create([
                'ranking' => random_int(0, 10)
            ]);
        }

        $samples = Sample::orderByRanking()->paginate(10);

        $samples->each(function ($thisSample, $index) use ($samples) {
            if ($index < ($samples->count() - 1)) {
                $nextSample = $samples[$index];

                $this->assertGreaterThanOrEqual(
                    $thisSample->ranking, $nextSample->ranking);
            }
        });
    }


    /** @test */
    public function cover_photo_file_is_deleted_when_sample_is_deleted()
    {
        $sample = factory(Sample::class)->create([
            'photoPath' => UploadedFile::fake()->create('photo.jpg')->store('images', 'public'),
        ]);

        $sampleCoverPhoto = $sample->fresh()->photoPath;
        $this->assertFileExists(public_path('storage/' . $sampleCoverPhoto));

        $sample->delete();

        $this->assertNull($sample->fresh());
        $this->assertFileNotExists(public_path('storage/' . $sampleCoverPhoto));
    }
}
