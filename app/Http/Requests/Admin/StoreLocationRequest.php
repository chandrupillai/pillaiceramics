<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLocationRequest extends FormRequest
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
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => [ 'string', 'max:255', 'unique:locations,slug'],
            'address'     => ['required', 'string', 'max:255'],
            'city'        => ['required', 'string', 'max:100'],
            'state'       => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'phone'       => ['nullable', 'string', 'max:20'],
            'email'       => ['nullable', 'email', 'max:255'],
            'is_active'   => ['nullable', 'boolean'],
        ];
    }
}
