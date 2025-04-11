<?php

namespace App\Services\Location;

use App\Http\Requests\Location\CreateLocationRequest;
use App\Http\Requests\Location\LocationQueryRequest;
use App\Http\Resources\LocationResource;
use App\Models\Location;
use App\Utils\Helpers\ModelCrudHelpers;
use App\Utils\Helpers\ResponseHelpers;
use App\Utils\Traits\RecordFilterTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LocationService implements LocationServiceInterface
{
    use RecordFilterTrait;

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

    public function retrieveLocations(LocationQueryRequest $queryRequest)
    {
        try {
            $query = Location::orderBy('created_at', 'desc');

            $this->applyLocationSearchTermFilter($query, $queryRequest['search_term'] ?? null);
            $locations = $query->get();

            return ResponseHelpers::ConvertToJsonResponseWrapper(
                LocationResource::collection($locations),
                'Locations retrieved successfully',
                200
            );
        } catch (Exception $e) {
            return ResponseHelpers::ConvertToJsonResponseWrapper(
                ['error' => $e->getMessage()],
                'Error retrieving locations',
                500
            );
        }
    }
}
