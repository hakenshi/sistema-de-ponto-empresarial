<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UsuariosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    public function authorize(Request $request): bool
    {
        if ($request->user()->id_cargo == 1){
        return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->method() == 'PATCH' || $this->method() == 'PUT') {
            return [
                'nome' => 'nullable',
                'email' => 'nullable|email|unique:users,email',
                'password' => 'nullable|min:3',
            ];
        }
        return [
            'nome' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3',
        ];
    }
}
