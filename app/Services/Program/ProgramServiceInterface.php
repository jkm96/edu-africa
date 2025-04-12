<?php

namespace App\Services\Program;

use App\Http\Requests\Program\UpsertProgramRequest;
use App\Http\Requests\Program\ProgramQueryRequest;

interface ProgramServiceInterface
{
    public function index(ProgramQueryRequest $queryRequest);
    public function store(UpsertProgramRequest $request);
    public function show($id);
    public function update(UpsertProgramRequest $request, $id);
    public function destroy($id);
}
