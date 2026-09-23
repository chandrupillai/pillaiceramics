<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreGodownRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'location_id'     => ['required', 'exists:locations,id'],
            'name'            => ['required', 'string', 'max:255'],
            'code'            => ['required', 'string', 'max:50', 'unique:godowns,code'],
            'address'         => ['nullable', 'string'],
            'incharge_person' => ['nullable', 'string', 'max:255'],
            'contact_number'  => ['nullable', 'string', 'max:20'],
            'is_active'       => ['nullable', 'boolean'],
        ];
    }
}