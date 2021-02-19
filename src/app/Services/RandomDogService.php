<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\RandomDog;

final class RandomDogService {

    private Client $httpClient;

    private const IMAGE_DIR = 'random-dog';

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getImages(): Collection
    {
        $data = $this->getResponseData();

        $this->storeImages($data['message']);

        return $this->getLatestFiveImages();
    }

    private function storeImages(array $array): void
    {
        $saveOnlyFirst = RandomDog::count() > 0;

        foreach ($array as $imageUrl) {
            $pathInfo = pathinfo($array[0]);

            $contents = file_get_contents($imageUrl);

            $filePath = self::IMAGE_DIR . "/{$pathInfo['basename']}";

            $this->saveImage($filePath, $contents);

            if ($saveOnlyFirst) {
                break;
            }
        }
    }

    private function saveImage(string $filePath, $contents): void
    {
        RandomDog::create(['name' => $filePath]);

        Storage::put($filePath, $contents);
    }

    private function getResponseData(): array
    {
        $response = $this->httpClient->get('https://dog.ceo/api/breeds/image/random/5');

        $responseBody = $response->getBody();

        $responseContent = $responseBody->getContents();

        return json_decode($responseContent, true);
    }

    private function getLatestFiveImages(): Collection
    {
        return RandomDog::orderByDesc('created_at')->limit(5)->get(['name']);
    }

}