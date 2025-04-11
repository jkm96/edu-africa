<?php

namespace App\Http\Requests\Institution;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateInstitutionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'type' => ['sometimes', 'string'],
            'accreditation_status' => ['sometimes', 'string'],
            'ownership_type' => ['sometimes', 'string'],
            'founded_year' => ['sometimes', 'integer', 'min:1000', 'max:' . date('Y')],
            'website_url' => ['sometimes', 'nullable', 'url'],
            'email' => ['sometimes', 'nullable', 'email'],
            'phone' => ['sometimes', 'nullable', 'string'],
            'logo_url' => ['sometimes', 'nullable', 'url'],
            'location_id' => ['sometimes', 'exists:locations,id']
        ];
    }
}
