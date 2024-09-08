<?php

namespace App\Http\Requests\calendar;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class UpdateWorkoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'userId' => ['required', 'integer', 'exists:users,id'],
            'workoutId' => ['required', 'integer', 'exists:workouts,id'],
            'date' => ['sometimes', 'date'],
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
            'userId.required' => 'L\'utilisateur est requis',
            'userId.integer' => 'L\'utilisateur est invalide',
            'userId.exists' => 'L\'utilisateur est invalide',

            'workoutId.required' => 'La séance est requise',
            'workoutId.integer' => 'La séance est invalide',
            'workoutId.exists' => 'La séance est invalide',

            'date.date' => 'La date est invalide',
        ];
    }
}
