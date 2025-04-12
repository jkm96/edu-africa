<?php

namespace App\Http\Requests\Program;

use App\Http\Requests\Shared\BaseQueryRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class ProgramQueryRequest extends BaseQueryRequest
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
                'institution' => ['nullable', 'string'],
                'level' => ['nullable', 'string'],
                'mode' => ['nullable', 'string'],
            ];
    }
}
