<?php

namespace App\Utils\Traits;

trait RecordFilterTrait
{
    use DateFilterTrait;

    /**
     * @param $query
     * @param $params
     * @return void
     */
    private function applyInstitutionFilters($query, $params)
    {
//        $this->applyDateFilters($query, $params['period_from'] ?? null, $params['period_to'] ?? null);
        $searchTerm = $params['search_term'] ?? null;

        if ($searchTerm) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('type', 'like', '%' . $searchTerm . '%')
                    ->orWhere('slug', 'like', '%' . $searchTerm . '%')
                    ->orWhere('website_url', 'like', '%' . $searchTerm . '%');
            });
        }
    }

    /**
     * @param $query
     * @param $searchTerm
     * @return void
     */
    private function applyLocationSearchTermFilter($query, $searchTerm)
    {
        if ($searchTerm) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('country', 'like', '%' . $searchTerm . '%')
                    ->orWhere('region', 'like', '%' . $searchTerm . '%')
                    ->orWhere('city', 'like', '%' . $searchTerm . '%');
            });
        }
    }

    /**
     * @param $query
     * @param array $filters
     * @return void
     */
    private function applyProgramFilters($query, array $filters)
    {
        // Filtering
        if (!empty($filters['institution'])) {
            $institutionValue = $filters['institution'];

            $query->whereHas('institution', function ($q) use ($institutionValue) {
                $q->where('name', 'like', '%' . $institutionValue . '%')
                    ->orWhere('slug', 'like', '%' . $institutionValue . '%')
                    ->orWhere('id', $institutionValue)
                    ->orWhere('slug', $institutionValue);
            });
        }

        if (!empty($filters['level'])) {
            $query->where('level', $filters['level']);
        }

        if (!empty($filters['mode'])) {
            $query->where('mode', $filters['mode']);
        }

        // Search
        if (!empty($filters['search_term'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search_term'] . '%')
                    ->orWhere('faculty_or_school', 'like', '%' . $filters['search_term'] . '%');
            });
        }
    }
}
