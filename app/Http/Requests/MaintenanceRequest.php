<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MaintenanceRequest extends FormRequest
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
    'locker_id'       => ['required', 'exists:lockers,id'],
    'reportByUser_id' => ['required', 'exists:users,id'],
    'sovleByUser_id'  => ['nullable', 'exists:users,id'],
    'reason'          => ['required', 'string', 'max:255'],
    'status'          => ['required', 'in:pending,in_progress,completed'],
    'report_at'       => ['nullable', 'date'],
    'solve_at'        => ['nullable', 'date', 'after_or_equal:report_at'],
];
    }
}
