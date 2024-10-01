<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UsuariosRequest extends FormRequest
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
        if ($this->method() == 'PATCH' || $this->method() == 'PUT') {
            return [
                'nome' => 'nullable',
                'curso' => 'nullable',
                'email' => 'nullable|email',
                'password' => 'nullable|min:3',
                'confirm-password' => 'nullable|min:3|same:password',
                'foto_perfil' => 'nullable|image',
            ];
        }
        return [
            'nome' => 'required',
            'curso' => 'required|exists:cursos,id',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3',
            'confirm-password' => 'required|min:3|same:password',
            'matricula' => 'required|max:10',
            'foto_perfil' => 'nullable',
        ];
    }
}
