<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'lastname'      => ['required', 'string', 'max:255'],
            'firstname'     => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255'],
            'subject'       => ['required', 'string', 'max:255'],
            'phone'         => ['required', 'string', 'max:255'],
            'message'       => ['required', 'string'],
            'terms'         => ['required', 'accepted'],
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
            'lastname.required'     => 'Le nom est obligatoire.',
            'lastname.string'       => 'Le nom doit être une chaîne de caractères.',
            'lastname.max'          => 'Le nom ne doit pas dépasser :max caractères.',

            'firstname.required'    => 'Le prénom est obligatoire.',
            'firstname.string'      => 'Le prénom doit être une chaîne de caractères.',
            'firstname.max'         => 'Le prénom ne doit pas dépasser :max caractères.',

            'email.required'        => 'L\'adresse email est obligatoire.',
            'email.string'          => 'L\'adresse email doit être une chaîne de caractères.',
            'email.email'           => 'L\'adresse email doit être une adresse email valide.',
            'email.max'             => 'L\'adresse email ne doit pas dépasser :max caractères.',

            'phone.required'        => 'Le numéro de téléphone est obligatoire.',
            'phone.string'          => 'Le numéro de téléphone doit être une chaîne de caractères.',
            'phone.max'             => 'Le numéro de téléphone ne doit pas dépasser :max caractères.',

            'subject.required'      => 'Le sujet est obligatoire.',
            'subject.string'        => 'Le sujet doit être une chaîne de caractères.',
            'subject.max'           => 'Le sujet ne doit pas dépasser :max caractères.',

            'message.required'      => 'Le message est obligatoire.',
            'message.string'        => 'Le message doit être une chaîne de caractères.',

            'terms.required'        => 'Vous devez accepter les conditions générales d\'utilisation.',
            'terms.accepted'        => 'Vous devez accepter les conditions générales d\'utilisation.',
        ];
    }
}
