<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
                'curso' => 'nullable|exists:cursos,id',
                'turno' => 'nullable|exists:turnos,id',
                'matricula' => [
                    'nullable',
                    'max:10',
                    Rule::unique('users', 'matricula')->ignore($this->route('user')->id)
                ],
                'email' => [
                    'nullable',
                    'email',
                    Rule::unique('users', 'email')->ignore($this->route('user')->id)
                ],
                'password' => 'nullable|min:3',
                'confirm-password' => 'nullable|min:3|same:password',
                'foto_perfil' => 'nullable|image',
            ];
        }
        return [
            'nome' => 'required',
            'turno' => 'required|exists:turnos,id',
            'curso' => 'required|exists:cursos,id',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3',
            'confirm-password' => 'required|min:3|same:password',
            'matricula' => 'required|max:10|unique:users,matricula',
            'foto_perfil' => 'nullable|image',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'curso.required' => 'O curso é obrigatório.',
            'curso.exists' => 'O curso selecionado é inválido.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser um endereço de e-mail válido.',
            'email.unique' => 'Este e-mail já está em uso.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos :min caracteres.',
            'confirm-password.required' => 'A confirmação da senha é obrigatória.',
            'confirm-password.min' => 'A confirmação da senha deve ter pelo menos :min caracteres.',
            'confirm-password.same' => 'As senhas não coincidem.',
            'matricula.required' => 'A matrícula é obrigatória.',
            'matricula.max' => 'A matrícula não pode ter mais de :max caracteres.',
            'matricula.unique' => 'A matrícula já foi registrada.',
            'foto_perfil.image' => 'O arquivo deve ser uma imagem.',
        ];
    }


}
