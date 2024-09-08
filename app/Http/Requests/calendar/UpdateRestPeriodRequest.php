<?php

namespace App\Http\Requests\calendar;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class UpdateRestPeriodRequest extends FormRequest
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
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'rest_period' => ['required', 'exists:rest_periods,id'],
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
            'start_date.required' => 'La date de début est requise',
            'start_date.date' => 'La date de début est invalide',

            'end_date.required' => 'La date de fin est requise',
            'end_date.date' => 'La date de fin est invalide',

            'rest_period.required' => 'La période de repos est requise',
            'rest_period.exists' => 'La période de repos est invalide',
        ];
    }
}
