<?php

namespace App\Http\Requests\admin\members;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class WorkoutRequest extends FormRequest
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
        ];
    }
}
