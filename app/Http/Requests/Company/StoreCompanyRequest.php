<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255',
            'email'     => 'nullable|email|max:255',
            'phone'     => 'nullable|string|max:20',
            'address'   => 'nullable|string|max:500',
            'logo'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // max 2MB
            'is_active' => 'nullable|boolean',
        ];
    }
}
