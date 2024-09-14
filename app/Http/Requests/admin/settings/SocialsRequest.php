<?php

namespace App\Http\Requests\admin\settings;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Auth;

class SocialsRequest extends FormRequest
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
            'company_facebook' => ['nullable', 'string', 'max:255'],
            'company_twitter' => ['nullable', 'string', 'max:255'],
            'company_instagram' => ['nullable', 'string', 'max:255'],
            'company_linkedin' => ['nullable', 'string', 'max:255'],
            'company_youtube' => ['nullable', 'string', 'max:255'],
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
            'company_facebook.string' => 'Le lien Facebook de la société doit être une chaîne de caractères.',
            'company_facebook.max' => 'Le lien Facebook de la société ne doit pas dépasser 255 caractères.',

            'company_twitter.string' => 'Le lien Twitter de la société doit être une chaîne de caractères.',
            'company_twitter.max' => 'Le lien Twitter de la société ne doit pas dépasser 255 caractères.',

            'company_instagram.string' => 'Le lien Instagram de la société doit être une chaîne de caractères.',
            'company_instagram.max' => 'Le lien Instagram de la société ne doit pas dépasser 255 caractères.',

            'company_linkedin.string' => 'Le lien LinkedIn de la société doit être une chaîne de caractères.',
            'company_linkedin.max' => 'Le lien LinkedIn de la société ne doit pas dépasser 255 caractères.',

            'company_youtube.string' => 'Le lien YouTube de la société doit être une chaîne de caractères.',
            'company_youtube.max' => 'Le lien YouTube de la société ne doit pas dépasser 255 caractères.',
        ];
    }
}
