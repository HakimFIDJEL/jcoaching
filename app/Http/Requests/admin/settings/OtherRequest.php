<?php

namespace App\Http\Requests\admin\settings;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Auth;

class OtherRequest extends FormRequest
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
            'meta_title' => ['required', 'string'],
            'meta_description' => ['required', 'string'],
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
            'meta_title.required' => 'Le titre de la page est obligatoire.',
            'meta_title.string' => 'Le titre de la page doit être une chaîne de caractères.',

            'meta_description.required' => 'La description de la page est obligatoire.',
            'meta_description.string' => 'La description de la page doit être une chaîne de caractères.',
        ];
    }
}
