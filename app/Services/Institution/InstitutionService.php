<?php

namespace App\Services\Institution;

use App\Http\Requests\Institution\CreateInstitutionRequest;
use App\Http\Requests\Institution\InstitutionQueryRequest;
use App\Http\Requests\Institution\UpdateInstitutionRequest;
use App\Http\Resources\InstitutionResource;
use App\Models\Institution;
use App\Models\Location;
use App\Utils\Helpers\ResponseHelpers;
use App\Utils\Traits\RecordFilterTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class InstitutionService implements InstitutionServiceInterface
{
    use RecordFilterTrait;

    public function index(InstitutionQueryRequest $queryRequest)
    {
        try {
            $query = Institution::orderBy('created_at', 'desc');

            $this->applyInstitutionFilters($query, $queryRequest);

            $pageSize = $queryRequest['page_size'] ?? 10;
            $currentPage = $queryRequest['page_number'] ?? 1;
            $institutions = $query->paginate($pageSize, ['*'], 'page', $currentPage);

            return ResponseHelpers::ConvertToPagedJsonResponseWrapper(
                InstitutionResource::collection($institutions->items()),
                'Institutions retrieved successfully',
                200,
                $institutions
            );
        } catch (Exception $e) {
            return ResponseHelpers::ConvertToPagedJsonResponseWrapper(
                ['error' => $e->getMessage()],
                'Error retrieving institutions',
                500
            );
        }
    }

    public function store(CreateInstitutionRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $location = Location::findOrFail($validatedData['location_id']);
            if (empty($location))
                throw new ModelNotFoundException("Location provided not found");

            $validatedData['latitude'] = $location->latitude;
            $validatedData['longitude'] = $location->longitude;
            $institution = Institution::create($validatedData);

            return ResponseHelpers::ConvertToJsonResponseWrapper(
                new InstitutionResource($institution),
                'Institution created successfully',
                201
            );
        } catch (Exception $e) {
            return ResponseHelpers::ConvertToJsonResponseWrapper(
                ['error' => $e->getMessage()],
                'Error creating institution',
                500
            );
        }
    }

    public function show(string $idOrSlug)
    {
        try {
            $query = Institution::with(['location']);

            $institution = is_numeric($idOrSlug)
                ? $query->find((int)$idOrSlug)
                : $query->where('slug', $idOrSlug)->first();

            if (empty($institution))
                throw new ModelNotFoundException("Institution not found");

            return ResponseHelpers::ConvertToJsonResponseWrapper(
                new InstitutionResource($institution),
                'Institution retrieved successfully',
                201
            );

        } catch (Exception $e) {
            return ResponseHelpers::ConvertToJsonResponseWrapper(
                ['error' => $e->getMessage()],
                'Error retrieving institution',
                500
            );
        }
    }

    public function update(UpdateInstitutionRequest $request, string $id)
    {
        try {
            $institution = is_numeric($id)
                ? Institution::find((int)$id)
                : Institution::where('slug', $id)->first();

            if (empty($institution))
                throw new ModelNotFoundException("Institution not found");

            $data = $request->validated();
            $location = Location::find($data['location_id']);
            if (empty($location))
                throw new ModelNotFoundException("Location provided not found");

            $data['latitude'] = $location->latitude;
            $data['longitude'] = $location->longitude;

            $institution->update($data);

            return ResponseHelpers::ConvertToJsonResponseWrapper(
                new InstitutionResource($institution->fresh()),
                'Institution updated successfully',
                200
            );
        } catch (Exception $e) {
            return ResponseHelpers::ConvertToJsonResponseWrapper(
                ['error' => $e->getMessage()],
                'Error updating institution',
                500
            );
        }
    }

    public function delete(string $id)
    {
        try {
            $institution = is_numeric($id)
                ? Institution::find((int)$id)
                : Institution::where('slug', $id)->first();

            if (empty($institution))
                throw new ModelNotFoundException("Institution not found");
            $name = $institution->name;
            $institution->delete();

            return ResponseHelpers::ConvertToJsonResponseWrapper(
                ['name'=> $name],
                'Institution deleted successfully',
                200
            );
        } catch (Exception $e) {
            return ResponseHelpers::ConvertToJsonResponseWrapper(
                ['error' => $e->getMessage()],
                'Failed to delete institution',
                500
            );
        }
    }
}
