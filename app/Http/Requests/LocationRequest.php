<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'type'    => ['required', 'in:building,library,shopping,sports,public'],
            'status'  => ['required', 'in:active,inactive'],
            'map'     => ['nullable', 'string', 'max:255'],
        ];
    }
}