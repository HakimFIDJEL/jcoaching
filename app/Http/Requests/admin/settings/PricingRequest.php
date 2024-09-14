<?php

namespace App\Http\Requests\admin\settings;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Auth;

class PricingRequest extends FormRequest
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
            'workout_price' => ['required', 'numeric'],
            'nutrition_price' => ['required', 'numeric'],
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
            'workout_price.required' => 'Le prix de l\'entraînement est obligatoire.',
            'workout_price.numeric' => 'Le prix de l\'entraînement doit être un nombre.',

            'nutrition_price.required' => 'Le prix de la nutrition est obligatoire.',
            'nutrition_price.numeric' => 'Le prix de la nutrition doit être un nombre.',
        ];
    }
}
