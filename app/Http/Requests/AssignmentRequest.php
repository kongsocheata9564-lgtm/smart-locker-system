<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'locker_id'         => ['required', 'exists:lockers,id'],
            'user_id'           => ['required', 'exists:users,id'],
            'one_time_password' => ['required', 'string', 'max:255'],
            'start_time'        => ['nullable', 'date'],
            'end_time'          => ['nullable', 'date', 'after_or_equal:start_time'],
        ];
    }
}