<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Program\UpsertProgramRequest;
use App\Http\Requests\Program\ProgramQueryRequest;
use App\Http\Requests\Program\UpdateProgramRequest;
use App\Services\Program\ProgramServiceInterface;
use Illuminate\Http\Request;

/**
 * @group Programs
 *
 * APIs for managing an institution programs
 */
class ProgramController extends Controller
{
    public function __construct(private ProgramServiceInterface $programService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ProgramQueryRequest $queryRequest)
    {
        return $this->programService->index($queryRequest);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpsertProgramRequest $request)
    {
        return $this->programService->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->programService->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpsertProgramRequest $request, string $id)
    {
        return $this->programService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->programService->destroy($id);
    }
}
