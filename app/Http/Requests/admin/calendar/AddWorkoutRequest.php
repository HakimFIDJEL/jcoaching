<?php

namespace App\Http\Requests\admin\calendar;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class AddWorkoutRequest extends FormRequest
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
            'nbr_sessions' => ['required', 'integer'],
            'user' => ['required', 'integer', 'exists:users,id'],
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
            'nbr_sessions.required' => 'Le nombre de sessions est requis',
            'nbr_sessions.integer' => 'Le nombre de sessions est invalide',

            'user.required' => 'L\'utilisateur est requis',
            'user.integer' => 'L\'utilisateur est invalide',
            'user.exists' => 'L\'utilisateur est invalide',
        ];
    }
}
