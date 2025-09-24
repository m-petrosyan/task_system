<?php

namespace App\Http\Controllers;

use App\Http\Requests\Availability\AvailabilityRequest;
use App\Http\Resources\User\UserResource;
use App\Repositories\AvailabilityRepository;
use App\Services\AvailabilityService;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class AvailabilityController extends Controller
{
    public function __construct(protected AvailabilityService $availabilityService)
    {
    }

    public function index(AvailabilityRequest $request): ResourceCollection
    {
        return UserResource::collection(AvailabilityRepository::index($request->is_available));
    }

    public function update(): Response
    {
        $this->availabilityService->update();

        return response()->noContent();
    }
}
