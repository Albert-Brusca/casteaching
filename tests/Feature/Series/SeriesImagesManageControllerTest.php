<?php

namespace Tests\Feature\Series;

use App\Models\Serie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
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

        $response = $this->put('/manage/series/' . $serie1->id . '/image/',[
            'image' => $file = UploadedFile::fake()->image('serie1.jpg'),
        ]);

        $response->assertRedirect();
        Storage::disk('public')->assertExists('/series/'. $file->hashName());
        $response->assertSessionHas('status', __('Successfully updated'));

        $this->assertEquals($serie1->refresh()->image,'series/'.$file->hashName());
        $this->assertNotNull($serie1->refresh()->image);
    }
}
