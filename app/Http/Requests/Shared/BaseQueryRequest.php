<?php

namespace App\Http\Requests\Shared;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BaseQueryRequest extends FormRequest
{
    /**
     * Get the validated data from the request and trim all string fields.
     *
     * @param null $key
     * @param null $default
     * @return array
     */
    public function validated($key = null, $default = null)
    {
        $validatedData = parent::validated();

        foreach ($validatedData as $key => $value) {
            if (is_string($value)) {
                $validatedData[$key] = trim($value);
            }
        }

        return $validatedData;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function commonRules()
    {
        return [
            'page_size' => 'integer|min:1',
            'page_number' => 'integer|min:1',
            'order_by' => 'nullable|string',
            'search_term' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'page_size.min' => 'The page size must be a positive number greater than zero.',
            'page_number.min' => 'The page number must be a positive number greater than zero.',
        ];
    }
}
