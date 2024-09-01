<?php

namespace App\Http\Requests\admin\calendar;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
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
            'user' => 'nullable|exists:users,id' // nullable pour permettre une valeur vide
        ];
    }

    public function messages(): array
    {
        return [
            'user.exists' => 'L\'utilisateur n\'existe pas'
        ];
    }

}
