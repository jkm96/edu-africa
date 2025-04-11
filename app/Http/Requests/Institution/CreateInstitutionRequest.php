<?php

namespace App\Http\Requests\Institution;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateInstitutionRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'max:100'],
            'accreditation_status' => ['nullable', 'string', 'max:100'],
            'ownership_type' => ['nullable', 'string', 'max:100'],
            'founded_year' => ['nullable', 'integer', 'min:1000', 'max:' . date('Y')],
            'website_url' => ['nullable', 'url'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'logo_url' => ['nullable', 'url'],
            'location_id' => ['required', 'exists:locations,id']
        ];
    }
}
