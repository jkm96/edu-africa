<?php

namespace App\Services\Institution;

use App\Http\Requests\Institution\InstitutionQueryRequest;
use App\Http\Resources\InstitutionResource;
use App\Models\Institution;
use App\Utils\Helpers\ResponseHelpers;
use Exception;

class InstitutionService implements InstitutionServiceInterface
{
    public function index(InstitutionQueryRequest $queryRequest)
    {
        try {
            $query = Institution::orderBy('created_at', 'desc');

            $pageSize = $queryParams['page_size'] ?? 10;
            $currentPage = $queryParams['page_number'] ?? 1;
            $institutions = $query->paginate($pageSize, ['*'], 'page', $currentPage);

            return ResponseHelpers::ConvertToPagedJsonResponseWrapper(
                InstitutionResource::collection($institutions->items()),
                'Institutions retrieved successfully',
                200,
                $institutions
            );
        } catch (Exception $e) {
            return ResponseHelpers::ConvertToPagedJsonResponseWrapper(
                ['error' => $e->getMessage()],
                'Error retrieving institutions',
                500
            );
        }
    }
}
