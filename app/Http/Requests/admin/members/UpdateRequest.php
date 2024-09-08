<?php

namespace App\Http\Requests\admin\members;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRequest extends FormRequest
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
            'lastname' => 'required|string|max:50',
            'firstname' => 'required|string|max:50',
            'email' => 'required|string|email|max:100|unique:users,email,' . $this->route('user')->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:100',
            'city' => 'required|string|max:50',
            'postal_code' => 'required|string|max:10',
            'address_complement' => 'nullable|string|max:250',
            'country' => 'required|string|max:50',
            'email_verified' => 'required|boolean',
            'first_session' => 'required|boolean',
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
            'lastname.required' => 'Le nom est requis',
            'lastname.string' => 'Le nom doit être une chaîne de caractères',
            'lastname.max' => 'Le nom ne doit pas dépasser 50 caractères',

            'firstname.required' => 'Le prénom est requis',
            'firstname.string' => 'Le prénom doit être une chaîne de caractères',
            'firstname.max' => 'Le prénom ne doit pas dépasser 50 caractères',

            'email.required' => 'L\'email est requis',
            'email.string' => 'L\'email doit être une chaîne de caractères',
            'email.email' => 'L\'email doit être une adresse email valide',
            'email.max' => 'L\'email ne doit pas dépasser 100 caractères',
            'email.unique' => 'L\'email est déjà utilisé',

            'phone.required' => 'Le téléphone est requis',
            'phone.string' => 'Le téléphone doit être une chaîne de caractères',
            'phone.max' => 'Le téléphone ne doit pas dépasser 20 caractères',

            'address.required' => 'L\'adresse est requise',
            'address.string' => 'L\'adresse doit être une chaîne de caractères',
            'address.max' => 'L\'adresse ne doit pas dépasser 100 caractères',

            'city.required' => 'La ville est requise',
            'city.string' => 'La ville doit être une chaîne de caractères',
            'city.max' => 'La ville ne doit pas dépasser 50 caractères',

            'postal_code.required' => 'Le code postal est requis',
            'postal_code.string' => 'Le code postal doit être une chaîne de caractères',
            'postal_code.max' => 'Le code postal ne doit pas dépasser 10 caractères',

            'address_complement.string' => 'Le complément d\'adresse doit être une chaîne de caractères',
            'address_complement.max' => 'Le complément d\'adresse ne doit pas dépasser 250 caractères',

            'country.required' => 'Le pays est requis',
            'country.string' => 'Le pays doit être une chaîne de caractères',
            'country.max' => 'Le pays ne doit pas dépasser 50 caractères',

            'email_verified.required' => 'La vérification de l\'email est requise',
            'email_verified.boolean' => 'La vérification de l\'email doit être un booléen',

            'first_session.required' => 'La première séance est requise',
            'first_session.boolean' => 'La première séance doit être un booléen',
        ];
    }
}
