<?php

namespace App\Http\Requests\Task;

use Illuminate\Contracts\Validation\ValidationRule;

class TaskUpdateRequest extends TaskCreateRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return array_merge(
            parent::rules(), [
                
            ]
        );
    }
}
