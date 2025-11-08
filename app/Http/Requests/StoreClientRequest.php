<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Requisitos: name, email, address son obligatorios. Email debe ser único.
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:clients,email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:255'],
        ];
    }
}
