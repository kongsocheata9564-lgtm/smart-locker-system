<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AssignmentRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id'],
            'locker_id' => ['required', 'exists:lockers,id'],
            'started_at' => ['required', 'date'],
            'released_at' => ['nullable', 'date', 'after_or_equal:started_at'],
            'status' => ['required', 'in:active,released,expired,cancelled'],
        ];
    }
}
