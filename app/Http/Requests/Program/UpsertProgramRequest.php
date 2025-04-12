<?php

namespace App\Http\Requests\Program;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpsertProgramRequest extends FormRequest
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
            'institution_id' => 'required',
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:100',
            'mode' => 'nullable|string|max:100',
            'duration' => 'nullable|string|max:50',
            'faculty_or_school' => 'nullable|string|max:255',
            'entry_requirements' => 'nullable|string',
            'tuition_fee' => 'nullable|numeric',
            'currency' => 'nullable|string|max:10',
            'language_of_instruction' => 'nullable|string|max:100',
        ];
    }
}
