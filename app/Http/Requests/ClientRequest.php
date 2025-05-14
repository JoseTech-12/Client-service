<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
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
        $clientId = $this->route('id'); // ← correcto, porque tu ruta usa {id}

        return [
            'id' => [
                'required',
                'string',
                Rule::unique('clients', 'id')->ignore($this->route('id'), 'id'),
            ],
            'nombre' => 'required|string|max:100|min:4',
            'email' => [
                'required',
                'email',
                Rule::unique('clients', 'email')->ignore($this->route('id'), 'id'),
            ],
            'telefono' => [
                'required',
                'string',
                'min:10',
                'max:10',
                Rule::unique('clients', 'telefono')->ignore($this->route('id'), 'id'),
            ]
        ];
    }
}
