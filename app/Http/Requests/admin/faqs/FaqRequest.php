<?php

namespace App\Http\Requests\admin\faqs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FaqRequest extends FormRequest
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
            'question' => 'required|string|max:191',
            'answer' => 'required|string|max:1500',
            'online' => 'required|boolean',
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
            'question.required' => 'La question est requise',
            'question.string' => 'La question doit être une chaîne de caractères',
            'question.max' => 'La question ne doit pas dépasser 191 caractères',

            'answer.required' => 'La réponse est requise',
            'answer.string' => 'La réponse doit être une chaîne de caractères',
            'answer.max' => 'La réponse ne doit pas dépasser 1500 caractères',

            'online.required' => 'La visibilité est requise',
            'online.boolean' => 'La visibilité doit être un booléen',
        ];
    }
}
