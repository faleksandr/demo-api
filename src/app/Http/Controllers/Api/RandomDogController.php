<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RandomDogResource;
use App\Services\RandomDogService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RandomDogController extends Controller
{
    private RandomDogService $randomDogService;

    public function __construct(RandomDogService $randomDogService)
    {
        $this->randomDogService = $randomDogService;
    }

    public function __invoke(Request $request)
    {
        $images = $this->randomDogService->getImages();

        return RandomDogResource::collection($images);

    }
}
