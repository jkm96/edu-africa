<?php

namespace App\Services\Institution;

use App\Http\Requests\Institution\InstitutionQueryRequest;

interface InstitutionServiceInterface
{
    public function index(InstitutionQueryRequest $queryRequest);
}
