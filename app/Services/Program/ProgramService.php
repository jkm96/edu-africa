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
        $institutionIdOrSlug = $request['institution_id'];

        $this->checkIfInstitutionExists($institutionIdOrSlug);

        $program = Program::create($request->validated());

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

        $this->checkIfInstitutionExists($request['institution_id']);

        $program->update($request->validated());

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
     * @return void
     */
    public function checkIfInstitutionExists(mixed $institutionIdOrSlug): void
    {
        $institution = is_numeric($institutionIdOrSlug)
            ? Institution::find((int)$institutionIdOrSlug)
            : Institution::where('slug', $institutionIdOrSlug)->first();

        if (empty($institution))
            throw new ModelNotFoundException("Institution not found");
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

