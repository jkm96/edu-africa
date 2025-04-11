<?php

namespace App\Services\Location;

use App\Http\Requests\Location\CreateLocationRequest;
use App\Http\Resources\LocationResource;
use App\Models\Location;
use App\Utils\Helpers\ModelCrudHelpers;
use App\Utils\Helpers\ResponseHelpers;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LocationService implements LocationServiceInterface
{
    public function store(CreateLocationRequest $createLocationRequest)
    {
        try {
            $location = Location::create($createLocationRequest->validated());
            return ResponseHelpers::ConvertToJsonResponseWrapper(
                new LocationResource($location),
                'Location added successfully',
                201
            );
        } catch (ModelNotFoundException $e) {
            return ModelCrudHelpers::itemNotFoundError($e);
        } catch (Exception $e) {
            return ResponseHelpers::ConvertToJsonResponseWrapper(
                ['error' => $e->getMessage()],
                'Error creating location ',
                500
            );
        }
    }
}
