<?php

namespace App\Utils\Traits;

use App\Models\Institution;

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
        $this->applyInstitutionSearchTermFilter($query, $params['search_term'] ?? null);
    }

    /**
     * @param $query
     * @param $searchTerm
     * @return void
     */
    private function applyInstitutionSearchTermFilter($query, $searchTerm)
    {
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
}
