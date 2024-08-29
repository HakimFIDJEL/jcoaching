<?php

namespace App\Http\Requests\admin\members;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PfpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pfp' => ['nullable', 'file', 'mimes:jpeg,png,jpg', 'max:2048'],
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
            'pfp.file' => 'La photo de profil doit être un fichier',
            'pfp.mimes' => 'La photo de profil doit être de type jpeg, png ou jpg',
            'pfp.max' => 'La photo de profil doit peser au maximum 2048 Ko',
        ];
    }
}
