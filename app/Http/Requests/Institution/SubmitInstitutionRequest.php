<?php

namespace App\Http\Requests\Institution;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SubmitInstitutionRequest extends FormRequest
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

            'location' => ['required', 'array'],
            'location.country' => ['required', 'string', 'max:255'],
            'location.region' => ['nullable', 'string', 'max:255'],
            'location.city' => ['nullable', 'string', 'max:255'],
            'location.postal_code' => ['nullable', 'string', 'max:50'],
            'location.latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'location.longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'location.timezone' => ['nullable', 'string', 'max:255'],

            'programs' => ['nullable', 'array'],
            'programs.*.name' => ['required', 'string', 'max:255'],
            'programs.*.level' => ['required', 'string', 'max:100'],
            'programs.*.mode' => ['nullable', 'string', 'max:100'],
            'programs.*.duration' => ['nullable', 'string', 'max:50'],
            'programs.*.faculty_or_school' => ['nullable', 'string', 'max:255'],
            'programs.*.entry_requirements' => ['nullable', 'string'],
            'programs.*.tuition_fee' => ['nullable', 'numeric'],
            'programs.*.currency' => ['nullable', 'string', 'max:10'],
            'programs.*.language_of_instruction' => ['nullable', 'string', 'max:100'],
        ];
    }
}
