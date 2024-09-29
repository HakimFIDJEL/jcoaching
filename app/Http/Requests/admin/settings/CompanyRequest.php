<?php

namespace App\Http\Requests\admin\settings;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Auth;

class CompanyRequest extends FormRequest
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
            'company_name' => ['nullable', 'string', 'max:255'],
            'company_address' => ['nullable', 'string', 'max:255'],
            'company_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'company_phone' => ['nullable', 'string', 'max:255'],
            'company_email' => ['nullable', 'string', 'email', 'max:255'],
            'company_siret' => ['nullable', 'string', 'max:255'],
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
            'company_name.string' => 'Le nom de la société doit être une chaîne de caractères.',
            'company_name.max' => 'Le nom de la société ne doit pas dépasser 255 caractères.',
            'company_address.string' => 'L\'adresse de la société doit être une chaîne de caractères.',
            'company_address.max' => 'L\'adresse de la société ne doit pas dépasser 255 caractères.',

            'company_logo.image' => 'Le logo de la société doit être une image.',
            'company_logo.mimes' => 'Le logo de la société doit être une image de type: jpeg, png, jpg.',
            'company_logo.max' => 'Le logo de la société ne doit pas dépasser 2 Mo.',

            'company_phone.string' => 'Le numéro de téléphone de la société doit être une chaîne de caractères.',
            'company_phone.max' => 'Le numéro de téléphone de la société ne doit pas dépasser 255 caractères.',

            'company_email.string' => 'L\'adresse email de la société doit être une chaîne de caractères.',
            'company_email.email' => 'L\'adresse email de la société doit être une adresse email valide.',
            'company_email.max' => 'L\'adresse email de la société ne doit pas dépasser 255 caractères.',

            'company_siret.string' => 'Le numéro SIRET de la société doit être une chaîne de caractères.',
            'company_siret.max' => 'Le numéro SIRET de la société ne doit pas dépasser 255 caractères.',
        ];
    }
}
