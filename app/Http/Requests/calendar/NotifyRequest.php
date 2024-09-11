<?php

namespace App\Http\Requests\calendar;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class NotifyRequest extends FormRequest
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
            'workouts' => 'array',
            'workouts.*' => 'required|integer|exists:workouts,id',
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
            'workouts.*.required' => 'Sélectionnez au moins un entraînement.',
            'workouts.*.integer' => 'L\'identifiant de l\'entraînement doit être un nombre.',
            'workouts.*.exists' => 'L\'entraînement sélectionné n\'existe pas.',
        ];
    }
}
