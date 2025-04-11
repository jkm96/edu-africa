<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Institution\InstitutionQueryRequest;
use App\Http\Resources\InstitutionResource;
use App\Models\Institution;
use App\Services\Institution\InstitutionServiceInterface;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    public function __construct(
        protected InstitutionServiceInterface $institutionService
    ) {}

    public function index(InstitutionQueryRequest $queryRequest)
    {
        return $this->institutionService->index($queryRequest);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
