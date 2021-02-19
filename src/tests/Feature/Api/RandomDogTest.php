<?php

namespace Tests\Feature\Api;

use App\RandomDog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RandomDogTest extends TestCase
{
    use RefreshDatabase;

    private const SHOULD_RETURN_IMAGES = 5;

    /**
     * @test
     */
    public function test_it_can_get_a_random_dog(): void
    {
        Storage::fake();

        $response = $this->get('/api/random-dog');

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonCount(self::SHOULD_RETURN_IMAGES);

        foreach ($response->decodeResponseJson() as $imageUrl) {
            Storage::assertExists($imageUrl);
        }
    }

    /**
     * @test
     */
    public function test_it_can_save_only_the_first_image_after_the_first_request(): void
    {
        Storage::fake();

        $expectResultCount = [5, 6, 7];

        foreach ($expectResultCount as $resultCount) {
            $response = $this->get('/api/random-dog');

            $response->assertStatus(Response::HTTP_OK);

            $response->assertJsonCount(self::SHOULD_RETURN_IMAGES);

            foreach ($response->decodeResponseJson() as $imageUrl) {
                Storage::assertExists($imageUrl);
            }

            $this->assertEquals($resultCount, RandomDog::count());
        }
    }
}
