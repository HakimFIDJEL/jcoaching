<?php

namespace App\Http\Requests\member\payment;

use Illuminate\Foundation\Http\FormRequest;

class ReductionRequest extends FormRequest
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
            'code' => ['required', 'string', 'max:191'],
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
            'code.required' => 'Le champ code est requis.',
            'code.string' => 'Le champ code doit être une chaîne de caractères.',
            'code.max' => 'Le champ code ne doit pas dépasser :max caractères.',
        ];
    }
}
