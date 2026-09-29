<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LockerRequest extends FormRequest
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
    'locker_name' => ['required', 'string', 'max:255'],
    'location_id' => ['required', 'exists:locations,id'],
    'type'        => ['required', 'string', 'max:255'],
    'status'      => ['required', 'in:available,occupied,maintenance,unavailable'],
];
    }
}
