<?php

namespace App\Http\Requests\admin\admins;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if(Auth::user()->isAdmin())
        {
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
        return [
            'current_password' => 'required|string|min:8|max:60',
            'password' => 'required|string|min:8|max:60|confirmed',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'current_password.required' => 'Le mot de passe actuel est requis',
            'current_password.string' => 'Le mot de passe actuel doit être une chaîne de caractères',
            'current_password.min' => 'Le mot de passe actuel doit contenir au moins 8 caractères',
            'current_password.max' => 'Le mot de passe actuel ne doit pas dépasser 60 caractères',
            
            'password.required' => 'Le nouveau mot de passe est requis',
            'password.string' => 'Le nouveau mot de passe doit être une chaîne de caractères',
            'password.min' => 'Le nouveau mot de passe doit contenir au moins 8 caractères',
            'password.max' => 'Le nouveau mot de passe ne doit pas dépasser 60 caractères',
            'password.confirmed' => 'Les mots de passe ne correspondent pas',
        ];
    }
}
