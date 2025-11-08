<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
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
        // Accedemos al ID del cliente a través de la ruta (route parameter)
        $client = $this->route('client'); 

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'email', 
                // Ignora la validación 'unique' para el email actual del cliente
                Rule::unique('clients', 'email')->ignore($client->id),
            ],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:255'],
        ];
    }
}
