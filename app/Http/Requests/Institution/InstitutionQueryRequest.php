<?php

namespace App\Http\Requests\Institution;

use App\Http\Requests\Shared\BaseQueryRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class InstitutionQueryRequest extends BaseQueryRequest
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
        return $this->commonRules() + [
            'location' => ['nullable', 'string'],
            'type' => ['nullable', 'string'],
        ];
    }
}
