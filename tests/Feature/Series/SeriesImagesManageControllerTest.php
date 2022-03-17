<?php

namespace Tests\Feature\Series;

use App\Events\SeriesImageUpdated;
use App\Models\Serie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\SeriesImagesManageController::class
 */
class SeriesImagesManageControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;
    /**
     * @test
     */
    public function series_managers_can_update_image_Series()
    {
        $this->loginAsSeriesManager();

        $serie1 = Serie::create([
            'title' => 'TDD',
            'description' => 'Apren tot sobre TDD',
            'image' => 'serieTDD.png',
            'teacher_name' => 'Albert Brusca'
        ]);

        Storage::fake('public');
        Event::fake();

        $response = $this->put('/manage/series/' . $serie1->id . '/image/',[
            'image' => $file = UploadedFile::fake()->image('serie.jpg',960,540),
        ]);

        Event::assertDispatched(SeriesImageUpdated::class, function ($event) use ($serie1) {
            return !is_null($event->serie->image) && $serie1->is($event->serie);
        });

        $response->assertRedirect();
        $response->assertSessionHas('status', __('Successfully updated'));
        Storage::disk('public')->assertExists('/series/'. $file->hashName());


        $this->assertEquals($serie1->refresh()->image,'series/'.$file->hashName());
        $this->assertNotNull($serie1->image);
        $this->assertFileEquals($file->getPathname(),Storage::disk('public')->path($serie1->image));
    }

    /** @test */
    public function series_image_have_to_be_an_image()
    {
        $this->loginAsSeriesManager();

        $serie1 = Serie::create([
            'title' => 'TDD',
            'description' => 'Aprèn tot sobre TDD',
            'image' => 'series/serieTDD.png',
            'teacher_name' => 'Albert Brusca'
        ]);

        Storage::fake('public');

        $response = $this->put('/manage/series/' . $serie1->id . '/image/',[
            'image' => $file = UploadedFile::fake()->create('serie1.pdf',0,'application/pdf'),
        ]);

        $response->assertRedirect();

        $response->assertSessionHasErrors('image');

        $this->assertEquals('series/serieTDD.png',$serie1->refresh()->image);


    }

    /** @test */
    function series_image_must_be_at_least_400px_height()
    {
        $this->loginAsSeriesManager();

        $serie1 = Serie::create([
            'title' => 'TDD',
            'description' => 'Aprèn tot sobre TDD',
            'image' => 'series/serieTDD.png',
            'teacher_name' => 'Albert Brusca'
        ]);

        Storage::fake('public');
        $response = $this->put('/manage/series/' . $serie1->id . '/image/',[
            'image' => $file = $file = UploadedFile::fake()->image('serie1.jpg', 200, 399),
        ]);

        $response->assertRedirect();

        $response->assertSessionHasErrors('image');

        $this->assertEquals('series/serieTDD.png',$serie1->refresh()->image);
    }

    /** @test */
    function series_image_must_be_aspect_ratio_16_9()
    {
        $this->loginAsSeriesManager();

        $serie1 = Serie::create([
            'title' => 'TDD',
            'description' => 'Aprèn tot sobre TDD',
            'image' => 'series/serieTDD.png',
            'teacher_name' => 'Sergi Tur'
        ]);

        Storage::fake('public');
        $response = $this->put('/manage/series/' . $serie1->id . '/image/', [
            'image' => $file = $file = UploadedFile::fake()->image('serie1.jpg', 6000, 400),
        ]);

        $response->assertRedirect();

        $response->assertSessionHasErrors('image');

        $this->assertEquals('series/serieTDD.png', $serie1->refresh()->image);
    }
}
