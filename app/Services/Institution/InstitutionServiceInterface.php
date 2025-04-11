<?php

namespace App\Services\Institution;

use App\Http\Requests\Institution\CreateInstitutionRequest;
use App\Http\Requests\Institution\InstitutionQueryRequest;
use App\Http\Requests\Institution\UpdateInstitutionRequest;
use App\Http\Requests\Location\CreateLocationRequest;

interface InstitutionServiceInterface
{
    public function index(InstitutionQueryRequest $queryRequest);

    public function store(CreateInstitutionRequest $request);

    public function show(string $idOrSlug);

    public function update(UpdateInstitutionRequest $request, string $id);

    public function delete(string $id);
}
