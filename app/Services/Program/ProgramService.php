<?php

namespace App\Services\Program;

use App\Http\Requests\Program\UpsertProgramRequest;
use App\Http\Requests\Program\ProgramQueryRequest;
use App\Http\Resources\ProgramResource;
use App\Models\Institution;
use App\Models\Program;
use App\Utils\Helpers\ResponseHelpers;
use App\Utils\Traits\RecordFilterTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProgramService implements ProgramServiceInterface
{
    use RecordFilterTrait;

    public function index(ProgramQueryRequest $queryRequest)
    {
        $query = Program::query();

        $filters = $queryRequest->validated();

        $this->applyProgramFilters($query, $filters);

        $pageSize = $filters['page_size'] ?? 10;
        $currentPage = $filters['page_number'] ?? 1;
        $programs = $query->paginate($pageSize, ['*'], 'page', $currentPage);

        return ResponseHelpers::ConvertToPagedJsonResponseWrapper(
            ProgramResource::collection($programs->items()),
            'Programs retrieved successfully',
            200,
            $programs
        );
    }

    public function store(UpsertProgramRequest $request)
    {
        $createData = $request->validated();

        $institutionIdOrSlug = $createData['institution_id'];
        $institution = $this->checkIfInstitutionExists($institutionIdOrSlug);
        $createData['institution_id'] = $institution->id;

        // Uniqueness check based on resolved institution ID
        $exists = Program::where('institution_id', $institution->id)
            ->whereRaw('LOWER(name) = ?', [strtolower($createData['name'])])
            ->exists();

        if ($exists) {
            return ResponseHelpers::ConvertToJsonResponseWrapper(
                [
                    'error' => 'The program name already exists in this institution.',
                    'institution_name' => $institution->name
                ],
                'Validation failed',
                422
            );
        }

        $program = Program::create($createData);

        return ResponseHelpers::ConvertToJsonResponseWrapper(
            new ProgramResource($program),
            'Program created successfully',
            201
        );
    }

    public function show($id)
    {
        $program = $this->getProgram($id);
        $program->load('institution');

        return ResponseHelpers::ConvertToJsonResponseWrapper(
            new ProgramResource($program),
            'Program retrieved successfully',
            200
        );
    }

    public function update(UpsertProgramRequest $request, $id)
    {
        $program = $this->getProgram($id);

        $updateRequest = $request->validated();
        $institution = $this->checkIfInstitutionExists($updateRequest['institution_id']);
        $updateRequest['institution_id'] = $institution->id;

        $exists = Program::where('institution_id', $institution->id)
            ->whereRaw('LOWER(name) = ?', [strtolower($updateRequest['name'])])
            ->where('id', '!=', $program->id)
            ->exists();

        if ($exists) {
            return ResponseHelpers::ConvertToJsonResponseWrapper(
                [
                    'error' => 'The program name already exists in this institution.',
                    'institution_name' => $institution->name
                ],
                'Validation failed',
                422
            );
        }

        $program->update($updateRequest);

        return ResponseHelpers::ConvertToJsonResponseWrapper(
            new ProgramResource($program),
            'Program updated successfully',
            200
        );
    }

    public function destroy($id)
    {
        $program = $this->getProgram($id);
        $program->delete();

        return ResponseHelpers::ConvertToJsonResponseWrapper(
            null,
            'Program deleted successfully',
            204
        );
    }

    /**
     * @param mixed $institutionIdOrSlug
     * @return mixed
     */
    public function checkIfInstitutionExists($institutionIdOrSlug)
    {
        $institution = is_numeric($institutionIdOrSlug)
            ? Institution::find((int)$institutionIdOrSlug)
            : Institution::where('slug', $institutionIdOrSlug)->first();

        if (empty($institution))
            throw new ModelNotFoundException("Institution not found");

        return $institution;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getProgram($id)
    {
        $program = is_numeric($id)
            ? Program::find((int)$id)
            : Program::where('slug', $id)->first();

        if (empty($program))
            throw new ModelNotFoundException("Program not found");

        return $program;
    }
}

