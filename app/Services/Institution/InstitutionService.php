<?php

namespace App\Services\Institution;

use App\Http\Requests\Institution\CreateInstitutionRequest;
use App\Http\Requests\Institution\InstitutionQueryRequest;
use App\Http\Requests\Institution\SubmitInstitutionRequest;
use App\Http\Requests\Institution\UpdateInstitutionRequest;
use App\Http\Resources\InstitutionResource;
use App\Http\Resources\ProgramResource;
use App\Models\Institution;
use App\Models\Location;
use App\Models\Program;
use App\Utils\Helpers\ResponseHelpers;
use App\Utils\Traits\RecordFilterTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Throwable;

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

    public function submit(SubmitInstitutionRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            // Create location
            $location = Location::create($data['location']);

            // Prepare institution data
            $institutionData = $data;
            $institutionData['location_id'] = $location->id;

            unset($institutionData['location'], $institutionData['programs']); // Optional, but safe

            $institution = Institution::create($institutionData);

            // Attach programs
            $programs = collect($data['programs'] ?? [])->map(function ($program) use ($institution) {
                $program['institution_id'] = $institution->id;
                return $program;
            });

            foreach ($programs as $programData) {
                Program::create($programData);
            }

            DB::commit();

            return ResponseHelpers::ConvertToJsonResponseWrapper(
                new InstitutionResource($institution->load(['location', 'programs'])),
                'Institution created successfully',
                201
            );
        } catch (Throwable $e) {
            DB::rollBack();

            return ResponseHelpers::ConvertToJsonResponseWrapper(
                null,
                'Failed to create institution: ' . $e->getMessage(),
                500
            );
        }
    }

    public function show(string $idOrSlug)
    {
        try {
            $institution = $this->getInstitution($idOrSlug);
            $institution->load(['location']);

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
            $institution = $this->getInstitution($id);
            $data = $request->validated();

            $location = Location::find($data['location_id']);
            if (empty($location))
                throw new ModelNotFoundException("Location provided not found");

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
            $institution = $this->getInstitution($id);
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

    /**
     * @param string $id
     * @return mixed
     */
    public function getInstitution(string $id)
    {
        $institution = is_numeric($id)
            ? Institution::find((int)$id)
            : Institution::where('slug', $id)->first();

        if (empty($institution))
            throw new ModelNotFoundException("Institution not found");

        return $institution;
    }

    public function programs(string $id)
    {
        $institution = $this->getInstitution($id);

        $programs = $institution->programs;

        return ResponseHelpers::ConvertToJsonResponseWrapper(
            ProgramResource::collection($programs),
            'Programs retrieved successfully',
            200
        );
    }
}
