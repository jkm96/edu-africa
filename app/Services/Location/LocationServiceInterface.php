<?php

namespace App\Services\Location;

use App\Http\Requests\Location\CreateLocationRequest;

interface LocationServiceInterface
{
    public function store(CreateLocationRequest $createLocationRequest);
}
