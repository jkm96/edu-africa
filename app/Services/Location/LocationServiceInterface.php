<?php

namespace App\Services\Location;

use App\Http\Requests\Location\CreateLocationRequest;
use App\Http\Requests\Location\LocationQueryRequest;

interface LocationServiceInterface
{
    public function store(CreateLocationRequest $createLocationRequest);

    public function retrieveLocations(LocationQueryRequest $queryRequest);
}
