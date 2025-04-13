<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Institution\CreateInstitutionRequest;
use App\Http\Requests\Institution\InstitutionQueryRequest;
use App\Http\Requests\Institution\SubmitInstitutionRequest;
use App\Http\Requests\Institution\UpdateInstitutionRequest;
use App\Http\Requests\Location\CreateLocationRequest;
use App\Http\Resources\InstitutionResource;
use App\Models\Institution;
use App\Services\Institution\InstitutionServiceInterface;
use Illuminate\Http\Request;

/**
 * @group Institutions
 *
 * APIs for managing institutions
 */
class InstitutionController extends Controller
{
    public function __construct(
        protected InstitutionServiceInterface $institutionService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(InstitutionQueryRequest $queryRequest)
    {
        return $this->institutionService->index($queryRequest);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateInstitutionRequest $request)
    {
        return $this->institutionService->store($request);
    }

    /**
     * Allows one to submit institution creation request alongside
     * location and a list of programs
     */
    public function submit(SubmitInstitutionRequest $request)
    {
        return $this->institutionService->submit($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->institutionService->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstitutionRequest $request, string $id)
    {
        return $this->institutionService->update($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->institutionService->delete($id);
    }

    /**
     * List an institution's programs.
     */
    public function programs(string $id)
    {
        return $this->institutionService->programs($id);
    }
}
